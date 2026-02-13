@extends('admin.layouts.master')
@section('title', 'Category')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/admin/extensions/simple-datatables/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/compiled/css/table-datatables.css') }}">
@endsection
@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Daftar Menu</h3>
                <p class="text-subtitle text-muted">Berbagai Pilihan Menu Terbaik</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <a href="{{ route('items.create') }}" class="btn btn-primary float-start float-lg-end mb-3">
                    <i class="bi bi-plus-lg"></i> Tambah Menu
                </a>
            </div>
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Simple Datatable
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama Item</th>
                            <th>Deskripsi</th>
                            <th>Harga</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item )
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    <img src="{{ $item->img }}" class="img-fluid rounded-top" width="50" alt="" onerror="this.onerror=null;this.src='https://via.placeholder.com/400x300?text=No+Image';">
                                </td>
                                <td>{{$item->name}}</td>
                                <td>{{Str::limit($item->description, 15)}}</td>
                                <td>{{'Rp'.number_format($item->price, 0, ',', '.')}}</td>
                                <td>
                                    @if($item->category->cat_name === 'Makanan')
                                        <span class="badge bg-warning">{{ $item->category->cat_name }}</span>
                                    @elseif($item->category->cat_name === 'Hidangan Utama')
                                        <span class="badge bg-warning">{{ $item->category->cat_name }}</span>
                                    @else
                                        <span class="badge bg-info">{{ $item->category->cat_name }}</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge {{ $item->is_available == 1 ? 'bg-success' : 'bg-danger'}}">
                                        {{ $item->is_available == 1 ? 'Tersedia' : 'Kosong'}}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('items.edit', $item->id ) }}" class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i> Update
                                    </a>
                                    <form action="{{ route('items.destroy', $item->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus menu ini?')">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>
@endsection
@section('scripts')
<script src="{{ asset('assets/admin/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
<script src="{{ asset('assets/admin/static/js/pages/simple-datatables.js') }}"></script>
@endsection