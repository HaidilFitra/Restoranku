@extends('admin.layouts.master')
@section('title', 'Tambah Karyawan')

@section('content')
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3>Tambah Daftar Karyawan</h3>
      <p class="text-subtitle text-muted">Silahkan isi data karyawan baru</p>
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
      <h5 class="alert-heading">Tambah Data Karyawan Error!</h5>
      @foreach ($errors->all() as $error )
      <li>{{$error}}</li>
      @endforeach
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <form class="form" action="{{ route('users.store')}}" enctype="multipart/form-data" method="POST">
      @csrf
      <div class="form-body">
        <div class="row"></div>
        <div class="col-12">
          <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
          </div>

          <div class="form-group">
            <label for="fullname">Nama Lengkap</label>
            <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Masukkan nama lengkap" required>
          </div>

          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email karyawan" required>
          </div>

          <div class="form-group">
            <label for="phone">Nomor Telepon</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Masukkan nomor telepon karyawan" required>
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
            <small><a href="#" class="toggle-password" data-target="password">Lihat Password</a></small>
          </div>

          <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi password" required>
            <small><a href="#" class="toggle-password" data-target="password_confirmation">Lihat Password</a></small>
            </div>

          <div class="form-group">
            <label for="">Role</label>
            <select name="role_id" id="role_id" class="form-select">
              @foreach ($roles as $role)
              <option value="{{$role->id}}">{{$role->role_name}}</option>
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
  document.querySelectorAll('.toggle-password').forEach(link => {
    link.addEventListener('click', function(e) {
      e.preventDefault();
      const target = this.getAttribute('data-target');
      const input = document.getElementById(target);
      if (input.type === 'password') {
        input.type = 'text';
        this.textContent = 'Sembunyikan Password';
      } else {
        input.type = 'password';
        this.textContent = 'Lihat Password';
      }
    });
  });
</script>
@endsection