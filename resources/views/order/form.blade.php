@extends('layouts.app')

@section('content')
    <form action="" method="POST" class="card mx-auto my-5 d-block p-5">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
        </div>
        <div class="form-group">
            <label for="medicines">Obat:</label>
            <select name="medicines[]" id="medicines">
                <option value="">Pilih Obat</option>
                @foreach($medicines as $medicine)
                    <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                @endforeach
            </select>
        </div>
    </form>
@endsection
