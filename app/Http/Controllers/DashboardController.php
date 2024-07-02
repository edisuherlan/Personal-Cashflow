<?php
// Aplikasi ini dikembangkan oleh Edi Suherlan
// mail: edisuherlan@gmail.com -->
// GitHub: https://github.com/edisuherlan

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::all();

        // Hitung total uang masuk dan uang keluar
        $totalUangMasuk = $transaksis->sum('uang_masuk');
        $totalUangKeluar = $transaksis->sum('uang_keluar');
   
        // Kirim data ke view untuk ditampilkan di grafik
        return view('dashboard', [
            'transaksis' => $transaksis,
            'totalUangMasuk' => $totalUangMasuk,
            'totalUangKeluar' => $totalUangKeluar,
        ]);
    }
}


