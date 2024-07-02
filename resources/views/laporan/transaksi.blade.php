<!-- Aplikasi ini dikembangkan oleh Edi Suherlan -->
<!-- Email: edisuherlan@gmail.com -->
<!-- GitHub: https://github.com/edisuherlan -->

@extends('layouts.app')

@section('title', 'Laporan Transaksi')

@section('content')
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <!-- Page Heading -->
                <h1 class="h3 mb-4 text-gray-800">Laporan Transaksi</h1>

                <!-- Search Form -->
                <form method="GET" action="{{ route('laporan.transaksi') }}" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari data..." value="{{ request()->query('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-secondary" type="submit">Cari</button>
                        </div>
                    </div>
                </form>

                @if(isset($transaksis) && $transaksis->count() > 0)
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Deskripsi</th>
                                <th>Uang Masuk</th>
                                <th>Uang Keluar</th>
                                <th>Foto Transaksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaksis as $transaksi => $item)
                                <tr>
                                    <td>{{ $transaksi + 1 + ($transaksis->currentPage() - 1) * $transaksis->perPage() }}</td>
                                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</td>
                                    <td>{{ $item->deskripsi }}</td>
                                    <td>{{ $item->uang_masuk ? 'Rp ' . number_format($item->uang_masuk, 2, ',', '.') : '-' }}</td>
                                    <td>{{ $item->uang_keluar ? 'Rp ' . number_format($item->uang_keluar, 2, ',', '.') : '-' }}</td>
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $transaksis->onEachSide(1)->links('pagination::bootstrap-4') }}
                    </div>
                @else
                    <p class="text-center">Tidak ada data transaksi.</p>
                @endif

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
@endsection
