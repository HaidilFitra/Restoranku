@extends('admin.layouts.master')
@section('title', 'Edit Menu')

@section('content')
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Edit Menu</h3>
      <p class="text-subtitle text-muted">Silahkan ubah data menu</p>
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
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <h5 class="alert-heading">Update Error!</h5>
      @foreach ($errors->all() as $error )
          <li>{{$error}}</li>
      @endforeach
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <form class="form" action="{{ route('items.update', $item->id)}}" enctype="multipart/form-data" method="POST">
      @csrf
      @method('PUT')
      <div class="form-body">
        <div class="row"></div>
        <div class="col-12">
          <div class="form-group">
            <label for="name">Nama Menu</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama menu" required value="{{ $item->name }}">
          </div>

          <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea class="form-control" id="description" name="description" placeholder="Masukkan deskripsi menu" required>{{ $item->description }}</textarea>
          </div>

          <div class="form-group">
            <label for="price">Harga</label>
            <input type="number" class="form-control" id="price" name="price" placeholder="Masukkan harga menu" required value="{{ $item->price }}">
          </div>

          <div class="form-group">
            <label for="category_id">Kategori</label>
            <select class="form-control" id="category_id" name="category_id" required>
              <option value="" disabled selected>Pilih Kategori</option>
              @foreach ($categories as $category)
              <option value="{{ $category->id }}" {{ $category->id == $item->category_id ? 'selected' : '' }}>{{ $category->cat_name }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="img">Gambar</label>
            @if ($item->img)
            <div class="mt-2 mb-2">
              <img src="{{ asset('img_item_upload/' . $item->img) }}" class="img-thumbnail" width="200" height="200" mb-2 alt="" onerror="this.onerror=null;this.src='{{$item->img}}';">
            </div>
            @endif
            <input type="file" class="form-control" id="img" name="img">
          </div>

          <div class="form-group">
            <label for="is_available">Status</label>
            <div class="form-check form-switch">
              <input type="hidden" name="is_available" value="0">
              <input type="checkbox" class="form-check-input" id="is_available" name="is_available" value="1" {{ $item->is_available == 1 ? 'checked' : '' }}>
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