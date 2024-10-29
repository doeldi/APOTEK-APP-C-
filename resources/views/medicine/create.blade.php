@extends('layouts.layout')

@section('content')
    <form action="{{ route('obat.simpan_obat') }}" method="post" class="card p-5">
        {{-- tag <form> attr action & method
            method :
            - GET : form tujuan mencari data (search)
            - POST : form tujuan menambahkan/menghapus/mengubah data
            action -> route untuk memproses data 
            - arahkan route yang akan menangani proses data ke db nya
            - jika GET  --}}
        @csrf
        @if (Session::get('success'))
            <div class="alert alert-success"> {{ Session::get('success') }} </div>
        @endif
        @if ($errors->any())
            <ul class="alert alert-danger p-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Nama Obat : </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="type" class="col-sm-2 col-form-label">Jenis Obat : </label>
            <div class="col-sm-10">
                <select name="type" id="type" class="form-select">
                    <option value="">Pilih Jenis Obat</option>
                    <option value="tablet" {{ old('type') == 'tablet' ? 'selected' : '' }}>Tablet</option>
                    <option value="sirup" {{ old('type') == 'sirup' ? 'selected' : '' }}>Sirup</option>
                    <option value="kapsul" {{ old('type') == 'kapsul' ? 'selected' : '' }}>Kapsul</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="price" class="col-sm-2 col-form-label">Harga: </label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="stock" class="col-sm-2 col-form-label">Stok Tersedia: </label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock') }}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Tambah Data</button>
    </form>
@endsection
