<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Makanan;
use App\Models\Pesanan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;
use Session;

class KeranjangController extends Controller
{
    public function tambahSementara(Request $request)
    {
        $request->validate([
            'makanan_id' => 'required|exists:makanan,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $makanan = Makanan::find($request->makanan_id);

        if ($makanan) {
            $itemKeranjang = [
                'makanan_id' => $makanan->id,
                'nama' => $makanan->nama,
                'harga' => $makanan->harga,
                'jumlah' => $request->jumlah,
                'total' => $makanan->harga * $request->jumlah,
            ];

            $keranjang = session()->get('keranjang', []);
            $keranjang[] = $itemKeranjang;
            session()->put('keranjang', $keranjang);

            return redirect()->route('keranjang.tampilKeranjang');
        } else {
            return redirect()->route('keranjang.tampilKeranjang')->with('error', 'Item tidak ditemukan!');
        }
    }

    // Tampilkan halaman keranjang
    public function tampilKeranjang()
    {
        $keranjang = session()->get('keranjang', []);
        return view('layouts.keranjang', compact('keranjang'));
    }

    // Hapus item dari keranjang sementara
    public function hapusDariKeranjang($index)
    {
        $keranjang = session()->get('keranjang', []);

        if (isset($keranjang[$index])) {
            unset($keranjang[$index]);
            $keranjang = array_values($keranjang); // Reindex array
            session()->put('keranjang', $keranjang);
            return redirect()->route('keranjang.tampilKeranjang')->with('success', 'Item berhasil dihapus dari keranjang.');
        }

        return redirect()->route('keranjang.tampilKeranjang')->with('error', 'Item tidak ditemukan di keranjang!');
    }
    public function simpanKeranjang(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_telp' => 'required|string|max:15',
        ]);

        $keranjang = session()->get('keranjang', []);
        if (empty($keranjang)) {
            return redirect()->route('keranjang.tampilKeranjang')->with('error', 'Keranjang kosong!');
        }

        $orderId = uniqid();

        // Create the pesanan entry
        $pesanan = Pesanan::create([
            'order_id' => $orderId,
            'nama' => $request->nama,
            'no_telp' => $request->no_telp,
            'tgl' => Carbon::now(),
            'total_harga' => array_sum(array_column($keranjang, 'total')),
            'status' => 'Unpaid',
        ]);

        foreach ($keranjang as $item) {
            Keranjang::create([
                'pesanan_id' => $pesanan->order_id,
                'makanan_id' => $item['makanan_id'],
                'jumlah' => $item['jumlah'],
                'total' => $item['total'],
            ]);
        }

        // Configure Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // Set up payment parameters
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $pesanan->total_harga,
            ],
            'customer_details' => [
                'first_name' => $request->nama,
                'phone' => $request->no_telp,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
        } catch (\Exception $e) {
            return redirect()->route('keranjang.tampilKeranjang')->with('error', 'Failed to generate payment token.');
        }

        session()->forget('keranjang');

        return view('layouts.keranjang', [
            'snapToken' => $snapToken,
            'totalHargaSemuaItem' => $pesanan->total_harga,
            'keranjang' => $keranjang,
            'order_id' => $orderId,
        ]);
    }

    public function callback(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'order_id' => 'required|string',
                'status_code' => 'required|string',
                'gross_amount' => 'required|string',
                'signature_key' => 'required|string',
            ]);

            $serverKey = config('midtrans.server_key');

            $cek = hash("sha512", $validatedData['order_id'] . $validatedData['status_code'] . $validatedData['gross_amount'] . $serverKey);

            if ($cek == $validatedData['signature_key']) {
                $order = Pesanan::where('order_id', $validatedData['order_id'])->firstOrFail();
                $order->update(['status' => $validatedData['status_code'] == '200' ? 'Paid' : 'Pending']);

                return redirect()->route('waiting.payment', ['order_id' => $validatedData['order_id']]);
            } else {
                return response()->json(['message' => 'Signature mismatch'], 400);
            }
        } catch (\Exception $e) {
            Log::error('Error handling Midtrans callback', ['exception' => $e]);
            return response()->json(['message' => 'Internal Server Error'], 500);
        }
    }

    public function waitingPayment($order_id)
    {
        $order = Pesanan::where('order_id', $order_id)->first();

        if (!$order) {
            return redirect()->route('home')->with('error', 'Order not found.');
        }

        // Check the payment status (assuming 'status' column exists)
        $status = $order->status;

        return view('layouts.waiting-payment', compact('status', 'order_id'));
    }

}