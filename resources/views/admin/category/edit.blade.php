@extends('admin.layouts.master')
@section('title', 'Edit Category')

@section('content')
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Edit Daftar Category</h3>
      <p class="text-subtitle text-muted">Silahkan ubah data category</p>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <a href="{{ route('categories.create') }}" class="btn btn-primary float-start float-lg-end mb-3">
        <i class="bi bi-plus-lg"></i> Tambah Category
      </a>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-body">
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <h5 class="alert-heading">Update Data Category Error!</h5>
      @foreach ($errors->all() as $error )
      <li>{{$error}}</li>
      @endforeach
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <form class="form" action="{{ route('categories.update', $category->id)}}" enctype="multipart/form-data" method="POST">
      @csrf
      @method('PUT')
      <div class="form-body">
        <div class="row"></div>
        <div class="col-12">
          <div class="form-group">
            <label for="cat_name">Nama Category</label>
            <input type="text" class="form-control" id="cat_name" name="cat_name" value="{{ old('cat_name', $category->cat_name) }}" placeholder="Masukkan nama category" required>
          </div>

          <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea class="form-control" id="description" name="description" placeholder="Masukkan deskripsi category" required rows="3">{{ old('description', $category->description) }}</textarea>
          </div>

          <div class="col-12 d-flex justify-content-end">
          <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
          <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
          <a href="{{ route('categories.index') }}" class="btn btn-primary me-1 mb-1">Kembali</a>
        </div>
      </div>
  </div>
  </form>
</div>
</div>
@endsection