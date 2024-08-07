<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;
    protected $table = 'pesanan';
    protected $primaryKey = 'order_id'; 

    public $incrementing = false;

    protected $fillable = [
        'nama',
        'no_telp',
        'tgl',
        'total_harga',
        'status',
        'order_id',
    ];

    public function keranjang()
    {
        return $this->hasMany(Keranjang::class);
    }
}