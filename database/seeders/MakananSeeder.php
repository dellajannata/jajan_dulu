<?php

namespace Database\Seeders;

use App\Models\Makanan;
use Illuminate\Database\Seeder;

class MakananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $makanan = [
            [
                'nama' => 'Seblak',
                'harga' => 12000,
                'gambar' => 'seblak.png'
            ],
            [
                'nama' => 'Soto Ayam',
                'harga' => 14000,
                'gambar' => 'soto.png'
            ],
            [
                'nama' => 'Nasi Goreng',
                'harga' => 13000,
                'gambar' => 'nasi_goreng.jpg'
            ],
            [
                'nama' => 'Ayam Tulang Lunak',
                'harga' => 25000,
                'gambar' => 'ayam.png'
            ],
            [
                'nama' => 'Mie Pedas',
                'harga' => 11000,
                'gambar' => 'mie.png'
            ],
        ];
        Makanan::insert($makanan);
    }
}