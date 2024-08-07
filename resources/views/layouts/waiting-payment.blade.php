@extends('layouts.main')

@section('layouts.content')
    <br>
    <div class="payment-info-container">
        <h2 class="text-center">Informasi Pembayaran</h2>
        <br>
        <div class="payment-info-content">
            <p><strong>Order ID:</strong> {{ $order_id }}</p>
            <p><strong>Status Pembayaran:</strong> {{ $status }}</p>

            @if ($status == 'Unpaid')
                <p class="status-unpaid">Pesanan Belum Dibayar.</p>
            @elseif($status == 'Paid')
                <p class="status-paid">Pembayaran Anda telah berhasil!</p>
            @else
                <p class="status-unknown">Status pembayaran tidak diketahui. Silakan hubungi layanan pelanggan.</p>
            @endif
        </div>
    </div>
@endsection
