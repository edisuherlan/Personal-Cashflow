<!-- Aplikasi ini dikembangkan oleh Edi Suherlan -->
<!-- Email: edisuherlan@gmail.com -->
<!-- GitHub: https://github.com/edisuherlan -->

@extends('layouts.app')

@section('title', 'Edit Uang Masuk')

@section('content')
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
           
            <div class="container-fluid">
                <h1 class="h3 mb-4 text-gray-800">Edit Transaksi Uang Masuk</h1>
                <form action="{{ route('uang_masuk.update', $transaksi->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $transaksi->tanggal }}" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <input type="text" class="form-control" id="deskripsi" name="deskripsi" value="{{ $transaksi->deskripsi }}" required>
                    </div>
                    <div class="form-group">
                        <label for="uang_masuk">Uang Masuk</label>
                        <input type="number" class="form-control" id="uang_masuk" name="uang_masuk" value="{{ $transaksi->uang_masuk }}" required>
                    </div>
                    <div class="form-group">
                        <label for="foto_transaksi">Foto Transaksi</label>
                        <input type="file" class="form-control" id="foto_transaksi" name="foto_transaksi">
                        @if($transaksi->foto_transaksi)
                            <img src="{{ Storage::url($transaksi->foto_transaksi) }}" alt="Foto Transaksi" width="100">
                        @endif
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('uang_masuk.index') }}" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        
@endsection
