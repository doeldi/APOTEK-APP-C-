@extends('layouts.layout')

@section('content')
    <div class="text-center d-flex justify-content-between">
        <h1>Data Akun</h1>
        <form class="d-flex mb-3" role="search" action="{{ route('akun.daftar_akun') }}" method="GET">
            <input type="text" class="form-control me-2" placeholder="Search Data Akun" aria-label="Search"
                name="search_akun">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </div>
    @if (Session::get('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
        </div>
    @endif

    @if (Session::get('deleted'))
        <div class="alert alert-warning">
            {{ Session::get('deleted') }}
        </div>
    @endif
    <table class="table table-bordered table-stripped">
        <thead class="text-center">
            <tr class="table-dark">
                <th>NO</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @if (count($users) < 1)
                <tr>
                    <td colspan="6" class="text-center">Data Akun Kosong</td>
                </tr>
            @else
                @foreach ($users as $index => $item)
                    <tr>
                        <td>{{ ($users->currentPage() - 1) * $users->perPage() + ($index + 1) }}</td>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['email'] }}</td>
                        <td>{{ $item['role'] }}</td>
                        <td class="d-flex justify-content-center">
                            <a href="{{ route('akun.edit_akun', $item['id']) }}" class="btn btn-primary me-3">Edit</a>
                            <button class="btn btn-danger btn-sm"
                                onclick="showModal('{{ $item['id'] }}' , '{{ $item['name'] }}')">Delete</button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <div class="d-flex justify-content-between">
        <button class="btn btn-primary">
            <a href="{{ route('akun.tambah_akun') }}" class="text-white">Tambah Data Akun</a>
        </button>

        <div class="pagination">
            {{ $users->links() }}
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="form-delete-obat" method="POST">
                @csrf
                {{-- menimpa method="POST" diganti menjadi delete, sesuai dengan http
                method untul menghapus data- --}}
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus Data Akun</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin ingin menghapus akun <span id="nama-akun"></span>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                        <button type="submit" class="btn btn-danger" id="confirm-delete">Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        function showModal(id, name) {
            let urlDelete = "{{ route('akun.delete_akun', ':id') }}";
            urlDelete = urlDelete.replace(':id', id);
            $('#form-delete-obat').attr('action', urlDelete);
            $('#exampleModal').modal('show');
            $('#nama-akun').text(name);
        }
    </script>
@endpush
