<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;
    protected $table = 'keranjang';
    protected $primarykey = 'id';

    protected $fillable = [
        'pesanan_id',
        'makanan_id',
        'jumlah',
        'total',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    public function makanan()
    {
        return $this->belongsTo(Makanan::class);
    }
}