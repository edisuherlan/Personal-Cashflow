<?php
// Aplikasi ini dikembangkan oleh Edi Suherlan
// mail: edisuherlan@gmail.com -->
// GitHub: https://github.com/edisuherlan

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $userEmail = Auth::user()->email;
        $transaksis = Transaksi::where('email', $userEmail)
                                ->when($search, function ($query, $search) {
                                    return $query->where('deskripsi', 'like', "%{$search}%")
                                                 ->orWhere('tanggal', 'like', "%{$search}%");
                                })
                                ->paginate(5); // Mengambil 5 data per halaman
        return view('laporan.transaksi', compact('transaksis'));
    }
}
