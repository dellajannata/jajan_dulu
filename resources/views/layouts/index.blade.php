@extends('layouts.main')
@section('layouts.content')
@include('layouts.detail_beranda')

<section class="menu">
    <h2 class="title-section" id="food-link">Daftar Menu</h2>
    <div class="food-link2">
        @foreach($makanan as $item)
            <div class="card" style="width: 18rem;">
                <img src="{{ asset('storage/' . $item->gambar) }}" class="rounded"
                style="width: 220px; height:160px">
                <div class="card-body">
                    <p class="card-text">{{ $item->nama }}</p>
                    <p class="card-text">Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                </div>
                <form action="{{ route('keranjang.tambahSementara') }}" method="POST">
                    @csrf
                    <input type="hidden" name="makanan_id" value="{{ $item->id }}">
                    <div class="form-group">
                        <input type="number" name="jumlah" placeholder="Jumlah" min="1" required>
                    </div>
                    <button type="submit" class="btn"><i class="fa fa-shopping-cart"></i> Pesan</button>
                </form>
            </div>
        @endforeach
    </div>
</section>
@include('layouts.paket_detail')
@endsection
