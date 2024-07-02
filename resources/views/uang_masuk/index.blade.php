<!-- Aplikasi ini dikembangkan oleh Edi Suherlan -->
<!-- Email: edisuherlan@gmail.com -->
<!-- GitHub: https://github.com/edisuherlan -->

@extends('layouts.app')

@section('title', 'Laporan Uang Masuk')

@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

       

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <h1 class="h3 mb-4 text-gray-800">Laporan Uang Masuk</h1>

                <!-- Your Content Here -->
                <a href="{{ route('uang_masuk.create') }}" class="btn btn-primary mb-4">Tambah Uang Masuk</a>

                <!-- Search Form -->
                <form method="GET" action="{{ route('uang_masuk.index') }}" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari data..." value="{{ request()->query('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-secondary" type="submit">Cari</button>
                        </div>
                    </div>
                </form>

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Deskripsi</th>
                            <th>Uang Masuk</th>
                            <th>Foto Transaksi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($uangMasuks->sortByDesc('tanggal') as $uangMasuk => $item)
                            @if($item->uang_masuk && is_null($item->uang_keluar) && $item->email == Auth::user()->email)
                                <tr>
                                    <td>{{ $uangMasuk + 1 + ($uangMasuks->currentPage() - 1) * $uangMasuks->perPage() }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                                    <td>{{ $item->deskripsi }}</td>
                                    <td>{{ 'Rp ' . number_format($item->uang_masuk, 2, ',', '.') }}</td>
                                    <td>
                                        @if($item->foto_transaksi)
                                            <a href="{{ Storage::url($item->foto_transaksi) }}" data-toggle="modal" data-target="#fotoModal{{ $item->id }}">
                                                <img src="{{ Storage::url($item->foto_transaksi) }}" alt="Foto Transaksi" width="100">
                                            </a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="fotoModal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="fotoModalLabel{{ $item->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="fotoModalLabel{{ $item->id }}">Foto Transaksi</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <img src="{{ Storage::url($item->foto_transaksi) }}" alt="Foto Transaksi" class="img-fluid">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('uang_masuk.edit', $item->id) }}" class="btn btn-warning btn-sm">Rubah</a>
                                        <button class="btn btn-danger btn-sm" onclick="confirmDelete({{ $item->id }});">Hapus</button>
                                        <form id="delete-form-{{ $item->id }}" action="{{ route('uang_masuk.destroy', $item->id) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $uangMasuks->onEachSide(1)->links('pagination::bootstrap-4') }}
                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

       

    </div>
    <!-- End of Content Wrapper -->
@endsection

@section('scripts')
<script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.min.js') }}"></script>
    @yield('scripts')
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apa kamu yakin?',
                text: "Data transaksi akan dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya, hapus saja!',
                cancelButtonText: 'Tidak, batalkan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            })
        }
    </script>
@endsection
