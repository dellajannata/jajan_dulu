@extends('layouts.main')
@section('layouts.content')
    <h2 style="text-align: center">Keranjang</h2>
    <br>
    <a href="{{ url('/makanan') }}" class="pesan-lain">+ Pesan lain</a>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th>Nama Makanan</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($keranjang as $index => $item)
                <tr>
                    <td>{{ $item['nama'] }}</td>
                    <td>Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                    <td>{{ $item['jumlah'] }}</td>
                    <td>Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                    <td>
                        <form action="{{ route('keranjang.hapus', ['index' => $index]) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this item?');">
                            @csrf
                            @method('DELETE')
                            <button class="delete" type="submit">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align: right;"><strong>Total:</strong></td>
                <td>Rp {{ number_format(array_sum(array_column($keranjang, 'total')), 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
    <br>
    <form class="keranjang-form" action="{{ route('keranjang.simpanKeranjang') }}" method="POST">
        @csrf
        <div class="form-keranjang">
            <input type="text" name="nama" placeholder="Nama" required>
        </div>
        <div class="form-keranjang">
            <input type="text" name="no_telp" placeholder="No Telp" required>
        </div>
        <button type="submit" id="pay-button" class="keranjang tambah">Pesan</button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        document.querySelectorAll('.tambah').forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();

                Swal.fire({
                    title: 'Apakah Pesanan Sudah Sesuai?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#1E90FF',
                    cancelButtonColor: '#DC143C',
                    confirmButtonText: 'Ya',
                    cancelButtonText: 'Tidak'
                }).then(function(result) {
                    if (result.isConfirmed) {
                        button.closest('form').submit();
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire('Dibatalkan', 'Pesanan berhasil.', 'info');
                    }
                });
            });
        });

        @if (session('success'))
            Swal.fire('Berhasil', '{{ session('success') }}', 'success');
        @endif

        @if (isset($snapToken))
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function (result) {
                    Swal.fire('Berhasil', 'Pembayaran berhasil!', 'success').then(() => {
                        window.location.href = "{{ route('waiting.payment', ['order_id' => $order_id]) }}";
                    });
                },
                onPending: function (result) {
                    Swal.fire('Menunggu', 'Pembayaran tertunda.', 'info');
                },
                onError: function (result) {
                    Swal.fire('Gagal', 'Pembayaran gagal.', 'error');
                },
                onClose: function () {
                    Swal.fire('Dibatalkan', 'Anda menutup popup tanpa menyelesaikan pembayaran.', 'info');
                }
            });
        @endif
    </script>
@endsection
