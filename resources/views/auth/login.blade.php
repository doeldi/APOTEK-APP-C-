@extends('layouts.layout')

@section('content')
    @if (Session::get('failed'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ Session::get('failed') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (Session::get('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 class="mb-0">Login</h3>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('login.proses') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}"
                        placeholder="Enter your email">
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Enter your password">
                </div>
                <div class="mb-4">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
                {{-- <div class="text-center">
                    <p class="mb-0">Don't have an account? <a href="{{ route('register') }}" class="text-primary">Register here</a></p>
                </div> --}}
            </form>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .login-container {
            max-width: 500px;
            margin: 100px auto;
        }

        .card {
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #28DF99;
            color: white;
            text-align: center;
            padding: 20px;
            border-radius: 15px 15px 0 0;
        }

        .btn-primary {
            width: 100%;
            padding: 10px;
            background-color: #28DF99;
        }

        .btn-primary:hover {
            background-color: #74b99e;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #28DF99;
        }
    </style>
@endpush
