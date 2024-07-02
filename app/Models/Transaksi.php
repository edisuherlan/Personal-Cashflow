<?php
// Aplikasi ini dikembangkan oleh Edi Suherlan
// mail: edisuherlan@gmail.com -->
// GitHub: https://github.com/edisuherlan

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DivisionByZeroError;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi'; // Pastikan nama tabel sesuai dengan yang ada di database

    protected $fillable = [
        'tanggal',
        'deskripsi',
        'uang_masuk',
        'uang_keluar',
        'foto_transaksi',
        'email', // Penambahan kolom email
    ];

     // Relasi dengan model User
     public function user()
     {
         return $this->belongsTo(User::class, 'email', 'email');
     }
}

