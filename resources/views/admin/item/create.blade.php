@extends('admin.layouts.master')
@section('title', 'Tambah Menu')

@section('content')
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Tambah Daftar Menu</h3>
      <p class="text-subtitle text-muted">Silahkan isi data menu baru</p>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <a href="{{ route('items.create') }}" class="btn btn-primary float-start float-lg-end mb-3">
        <i class="bi bi-plus-lg"></i> Tambah Menu
      </a>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <form class="form" action="{{ route('items.store')}}" enctype="multipart/form-data">
      @csrf
      <div class="form-body">
        <div class="row"></div>
          <div class="col-12">
        <div class="form-group">
          <label for="name">Nama Menu</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama menu" required>
        </div>

        <div class="form-group">
          <label for="description">Deskripsi</label>
          <input type="text" class="form-control" id="description" name="description" placeholder="Masukkan deskripsi menu" required>
        </div>

        <div class="form-group">
          <label for="price">Harga</label>
          <input type="number" class="form-control" id="price" name="price" placeholder="Masukkan harga menu" required>
        </div>

        <div class="form-group">
          <label for="category_id">Kategori</label>
          <select class="form-control" id="category_id" name="category_id" required>
            <option value="" disabled selected>Pilih Kategori</option>
            @foreach ($categories as $category)
          <option value="{{ $category->id }}">{{ $category->cat_name }}</option>
            @endforeach
          </select>
        </div>

         <div class="form-group">
          <label for="img">Gambar</label>
          <input type="file" class="form-control" id="img" name="img" required>
        </div>

        <div class="form-group">
          <label for="is_available">Status</label>
          <div class="form-check form-switch">
            <input type="hidden" name="is_available" value="0">
            <input type="checkbox" class="form-check-input" id="is_available" name="is_available" value="1" checked>
            <label class="form-check-label" for="is_available">Tersedia/Kosong</label>
          </div>
        </div>
          </div>

          <div class="col-12 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
        <a href="{{ route('items.index') }}" class="btn btn-primary me-1 mb-1">Kembali</a>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection