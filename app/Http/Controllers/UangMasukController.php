<?php
// Aplikasi ini dikembangkan oleh Edi Suherlan
// mail: edisuherlan@gmail.com -->
// GitHub: https://github.com/edisuherlan

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UangMasukController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $userEmail = Auth::user()->email;
        $uangMasuks = Transaksi::whereNotNull('uang_masuk')
                                ->whereNull('uang_keluar')
                                ->where('email', $userEmail)
                                ->when($search, function ($query, $search) {
                                    return $query->where('deskripsi', 'like', "%{$search}%")
                                                 ->orWhere('tanggal', 'like', "%{$search}%");
                                })
                                ->orderBy('tanggal', 'desc') // Mengurutkan berdasarkan tanggal terbaru dahulu
                                ->paginate(5); // Mengambil 5 data per halaman

        // Format tanggal ke format SQL
        $uangMasuks->getCollection()->transform(function ($item) {
            $item->tanggal = Carbon::parse($item->tanggal)->format('Y-m-d');
            return $item;
        });

        return view('uang_masuk.index', compact('uangMasuks'));
    }

    public function create()
    {
        return view('uang_masuk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string|max:255',
            'uang_masuk' => 'required|numeric',
            'foto_transaksi' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();
        $data['email'] = Auth::user()->email;
        $data['tanggal'] = Carbon::parse($data['tanggal'])->format('Y-m-d');
        if ($request->hasFile('foto_transaksi')) {
            $path = $request->file('foto_transaksi')->store('public/foto_transaksi');
            $data['foto_transaksi'] = $path;
        }

        Transaksi::create($data);

        return redirect()->route('uang_masuk.index')
                        ->with('success', 'Transaksi uang masuk berhasil dibuat.');
    }

    public function edit($id)
    {
        $transaksi = Transaksi::find($id);
        $transaksi->tanggal = Carbon::parse($transaksi->tanggal)->format('Y-m-d');
        return view('uang_masuk.edit', compact('transaksi'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'deskripsi' => 'required|string|max:255',
            'uang_masuk' => 'required|numeric',
            'foto_transaksi' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $transaksi = Transaksi::find($id);
        $data = $request->all();
        $data['email'] = Auth::user()->email;
        $data['tanggal'] = Carbon::parse($data['tanggal'])->format('Y-m-d');
        if ($request->hasFile('foto_transaksi')) {
            $path = $request->file('foto_transaksi')->store('public/foto_transaksi');
            $data['foto_transaksi'] = $path;
        } else {
            $data['foto_transaksi'] = $transaksi->foto_transaksi;
        }

        $transaksi->update($data);

        return redirect()->route('uang_masuk.index')
                        ->with('success', 'Transaksi uang masuk berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::find($id);
        $transaksi->delete();

        return redirect()->route('uang_masuk.index')
                        ->with('success', 'Transaksi uang masuk berhasil dihapus.');
    }
}
