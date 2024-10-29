@extends('layouts.layout')

@section('content')
    <h1 class="d-flex justify-content-center">Halaman Edit Obat</h1>
    <form action="{{ route('akun.edit.akun', $users['id']) }}" method="post" class="card p-5">
        @csrf
        @method('PATCH')

        @if (Session::get('success'))
            <div class="alert alert-success"> {{ Session::get('success') }} </div>
        @endif

        @if ($errors->any())
            <ul class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Nama: </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="{{ $users['name'] }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="email" class="col-sm-2 col-form-label">Email: </label>
            <div class="col-sm-10">
                <input type="email" class="form-control" id="email" name="email" value="{{ $users['email'] }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="role" class="col-sm-2 col-form-label">Tipe Akun: </label>
            <div class="col-sm-10">
                <select name="role" id="role" class="form-select">
                    <option value="">Pilih Tipe Akun</option>
                    <option value="admin" {{ $users['role'] == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="cashier" {{ $users['role'] == 'cashier' ? 'selected' : ''}}>Kasir</option>
                    <option value="user" {{ $users['role'] == 'user' ? 'selected' : '' }}>User</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="password" class="col-sm-2 col-form-label">Ubah Password: </label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="password" name="password">
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Ubah Data</button>
    </form>
@endsection
