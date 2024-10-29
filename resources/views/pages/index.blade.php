@extends('layouts.layout')

@section('content')
    <div class="jumbotron py-4 px-5">
        {{-- session failed --}}
        @if (Session::get('failed'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ Session::get('failed') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif                                                           

        <h1 class="display-4">Selamat Datang {{ Auth::user()->name }}!</h1>
        <hr class="my-4">
        <p>Aplikasi ini digunakan hanya oleh pegawai administrator APOTEK. Digunakan untuk mengelola data obat, penyetokan,
            juga pembelian (kasir).</p>
    </div>
@endsection
