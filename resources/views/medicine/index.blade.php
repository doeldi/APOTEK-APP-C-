@extends('layouts.layout')

@section('content')
    <div class="text-center d-flex justify-content-between">
        <h1>Data Obat</h1>
        <form class="d-flex mb-3" role="search" action="{{ route('obat.data_obat') }}" method="GET">
            <input type="text" class="form-control me-2" placeholder="Search Data Obat" aria-label="Search"
                name="search_obat">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </div>

    <form action="{{ route('obat.data_obat') }}" method="GET" class="d-flex mb-2">
        <select name="sort_stock" class="form-select me-2">
            <option value="">Sort by Stock</option>
            <option value="low" {{ Request::get('sort_stock') == 'low' ? 'selected' : '' }}>Terkecil</option>
            <option value="high" {{ Request::get('sort_stock') == 'high' ? 'selected' : '' }}>Terbesar</option>
        </select>
        <button type="submit" class="btn btn-primary">Sort</button>
    </form>


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
                <th>Tipe</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody class="text-center">
            @if (count($medicines) < 1)
                <tr>
                    <td colspan="6" class="text-center">Data Obat Kosong</td>
                </tr>
            @else
                @foreach ($medicines as $index => $item)
                    <tr>
                        <td>{{ ($medicines->currentPage() - 1) * $medicines->perPage() + ($index + 1) }}</td>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['type'] }}</td>
                        <td>Rp. {{ number_format($item['price'], 0, ',', '.') }}</td>
                        <td class="{{ $item['stock'] <= 3 ? 'bg-danger text-white' : '' }}" style="cursor: pointer"
                            onclick="showModalStock('{{ $item->id }}' , '{{ $item->stock }}')">{{ $item['stock'] }}
                        </td>
                        <td class="d-flex justify-content-center">
                            <a href="{{ route('obat.edit', $item['id']) }}" class="btn btn-primary me-3">Edit</a>
                            <button class="btn btn-danger btn-sm"
                                onclick="showModal('{{ $item['id'] }}' , '{{ $item['name'] }}')">Delete</button>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    {{-- stock modal --}}
    <div class="modal fade" id="modal_edit_stock" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="form_edit_stock" method="POST">
                @csrf
                {{-- menimpa method="POST" diganti menjadi delete, sesuai dengan http
                method untul menghapus data- --}}
                @method('PATCH')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Obat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="stock_edit">Stok</label>
                            <input type="number" class="form-control" id="stock_edit" name="stock">
                            @if (Session::get('failed'))
                                <small class="text-danger">{{ Session::get('failed') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                        <button type="submit" class="btn btn-primary" id="confirm-delete">Edit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- delete modal --}}
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="form-delete-obat" method="POST">
                @csrf
                {{-- menimpa method="POST" diganti menjadi delete, sesuai dengan http
                method untul menghapus data- --}}
                @method('DELETE')
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Hapus Data Obat</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin ingin menghapus obat <span id="nama-obat"></span>?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batalkan</button>
                        <button type="submit" class="btn btn-danger" id="confirm-delete">Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="d-flex justify-content-between">
        <button class="btn btn-primary">
            <a href="{{ route('obat.tambah_obat') }}" class="text-white">Tambah Data Obat</a>
        </button>

        {{-- add style for button pagination --}}
        <div class="pagination">
            {{ $medicines->links() }}
        </div>
    </div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        function showModal(id, name) {
            let urlDelete = "{{ route('obat.delete', ':id') }}";
            urlDelete = urlDelete.replace(':id', id);
            $('#form-delete-obat').attr('action', urlDelete);
            $('#exampleModal').modal('show');
            $('#nama-obat').text(name);
        }

        function showModalStock(id, stock) {
            $('#stock_edit').val(stock);
            let urlEditStock = "{{ route('obat.edit.stok', ':id') }}";
            urlEditStock = urlEditStock.replace(':id', id);
            $('#form_edit_stock').attr('action', urlEditStock);
            $('#modal_edit_stock').modal("show");
        }

        @if (Session::get('failed'))
            $(document).ready(function() {
                let id = {{ Session::get('id') }}
                let stock = {{ Session::get('stock') }}
                showModalStock(id, stock);
            });
        @endif
    </script>
@endpush
