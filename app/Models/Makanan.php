<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Makanan extends Model
{
    use HasFactory;

    protected $table = 'makanan';
    protected $primarykey = 'id';

    protected $fillable = [
        'nama',
        'harga',
        'gambar'
    ];

    // Relasi ke tabel Keranjang
    public function keranjang()
    {
        return $this->hasMany(Keranjang::class);
    }
}