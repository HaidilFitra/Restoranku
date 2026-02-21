@extends('admin.layouts.master')
@section('title', 'Edit Karyawan')

@section('content')
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Edit Karyawan</h3>
      <p class="text-subtitle text-muted">Silahkan ubah data karyawan</p>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <a href="{{ route('users.create') }}" class="btn btn-primary float-start float-lg-end mb-3">
        <i class="bi bi-plus-lg"></i> Tambah Karyawan
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
    <form class="form" action="{{ route('users.update', $user->id)}}" enctype="multipart/form-data" method="POST">
      @csrf
      @method('PUT')
      <div class="form-body">
        <div class="row"></div>
        <div class="col-12">
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required value="{{ $user->username }}">
          </div>

          <div class="form-group">
            <label for="fullname">Nama Lengkap</label>
            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Masukkan nama lengkap" required value="{{ $user->fullname }}">
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email karyawan" required value="{{ $user->email }}">
          </div>

          <div class="form-group">
            <label for="phone">Nomor Telepon</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Masukkan nomor telepon karyawan" required value="{{ $user->phone }}">
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password baru">
            <small><a href="#" class="toggle-password" data-target="password">Lihat Password</a></small>
          </div>

          <div class="form-group">
            <label for="">Role</label>
            <select name="role_id" id="role_id" class="form-select">
              @foreach ($roles as $role)
              <option value="{{$role->id}}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{$role->role_name}}</option>
              @endforeach
            </select>
          </div>

          <div class="col-12 d-flex justify-content-end">
          <button type="submit" class="btn btn-primary me-1 mb-1">Simpan</button>
          <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
          <a href="{{ route('users.index') }}" class="btn btn-primary me-1 mb-1">Kembali</a>
        </div>
      </div>
  </div>
  </form>
</div>
</div>
<script>
  document.querySelectorAll('.toggle-password').forEach(function(element) {
    element.addEventListener('click', function(e) {
      e.preventDefault();
      const targetId = this.getAttribute('data-target');
      const targetInput = document.getElementById(targetId);
      if (targetInput.type === 'password') {
        targetInput.type = 'text';
        this.textContent = 'Sembunyikan Password';
      } else {
        targetInput.type = 'password';
        this.textContent = 'Lihat Password';
      }
    });
  });
</script>
@endsection