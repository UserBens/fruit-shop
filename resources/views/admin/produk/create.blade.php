@extends('admin.layouts')

@section('konten')
    <div class="pb-3"><a href="{{ route('produk.index') }}" class="btn btn-secondary">Kembali</a></div>

    <form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="nama_produk" class="form-label">Nama Produk</label>
            <input type="text" class="form-control form-control-sm @error('nama_produk') is-invalid @enderror"
                name="nama_produk" id="nama_produk" aria-describedby="helpId" placeholder="Nama Produk"
                value="{{ old('nama_produk') }}">
            @error('nama_produk')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">Gambar Produk</label>
            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image">
            @error('image')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="harga_produk" class="form-label">Harga Produk</label>
            <input type="text" class="form-control form-control-sm @error('harga_produk') is-invalid @enderror"
                name="harga_produk" id="harga_produk" aria-describedby="helpId" placeholder="Harga Produk"
                value="{{ old('harga_produk') }}">
            @error('harga_produk')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="stok_produk" class="form-label">Stok Produk</label>
            <input type="text" class="form-control form-control-sm @error('stok_produk') is-invalid @enderror"
                name="stok_produk" id="stok_produk" aria-describedby="helpId" placeholder="Stok Produk"
                value="{{ old('stok_produk') }}">
            @error('stok_produk')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <label for="file" class="form-label">Status Produk</label>
        <select class="form-select mb-3" aria-label="Default select example" name="status">
            <option value="Aktif">Aktif</option>
            <option value="Tidak Aktif">Tidak Aktif</option>
        </select>

        <div class="mb-3">
            <label for="deskripsi_produk" class="form-label">Deskripsi Produk</label>
            <input id="deskripsi_produk" type="hidden" name="deskripsi_produk" value="{{ old('deskripsi_produk') }}">
            <trix-editor input="deskripsi_produk"></trix-editor>
            @error('deskripsi_produk')
                <p class="text-danger">{{ $message }}</p>
            @enderror
        </div>


        <button class="btn btn-primary" name="simpan" type="submit">Submit</button>
    </form>
@endsection
