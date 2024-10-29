@extends('layouts.layout')

@section('content')
    <form action="{{ route('akun.simpan_akun') }}" method="post" class="card p-5">
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
            <label for="name" class="col-sm-2 col-form-label">Nama: </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">Email: </label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email" value="{{ old('price') }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="role" class="col-sm-2 col-form-label">Tipe Akun: </label>
            <div class="col-sm-10">
                <select name="role" id="role" class="form-select">
                    <option value="">Pilih Tipe Akun</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="cashier" {{ old('role') == 'cashier' ? 'selected' : ''}}>Kasir</option>
                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Tambah Data</button>
    </form>
@endsection
