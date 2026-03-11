@extends('admin.layouts.master')
@section('title', 'Detail Pesanan')
@section('css')
<link rel="stylesheet" href="{{ asset('assets/admin/extensions/simple-datatables/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/admin/compiled/css/table-datatables.css') }}">
@endsection
@section('content')
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Detail Pesanan</h3>
                <p class="text-subtitle text-muted">Lihat detail pesanan yang telah dibuat oleh pelanggan</p>
            </div>
            <!-- <div class="col-12 col-md-6 order-md-2 order-first">
                <a href="{{ route('items.create') }}" class="btn btn-primary float-start float-lg-end mb-3">
                    <i class="bi bi-plus-lg"></i> Tambah Menu
                </a>
            </div> -->
        </div>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    {{ $order->order_code }}
                </h5>
                <div>
                    @if (Auth::user()->role->role_name == 'Administrator' || Auth::user()->role->role_name == 'cashier')
                        @if ($order->status == 'pending' && $order->payment_method == 'tunai')
                            <form action="{{route('orders.updateStatus', $order->id)}}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="bi bi-check-lg"></i> Settle
                                </button>
                            </form>
                        @endif
                    @elseif (Auth::user()->role->role_name == 'chef' && $order->status == 'settlement')
                            <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="status" value="cooked">
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="bi bi-check-circle"></i> Pesanan Siap
                                </button>
                            </form>
                    @endif
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p>Dibuat Pada: {{ $order->created_at->format('d M Y H:i') }}</p>
                        <p>Nama Pelanggan: {{ $order->user->fullname }}</p>
                        <p>Status:
                            <span class="badge {{ $order->status == 'settlement' ? 'bg-success' : ($order->status == 'cooked' ? 'bg-primary' : 'bg-warning') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p>No. Meja: {{ $order->table_number }}</p>
                        <p>Metode Pembayaran: {{ $order->payment_method }}</p>
                        <p>Catatan: {{ $order->note ?? '-' }}</p>
                    </div>
                </div>
            </div>
    </section>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Daftar Menu Yang Dipesan
                </h5>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama Menu</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderItems as $menu)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ asset('img_item_upload/' . $menu->item->img) }}" class="img-fluid rounded-top" width="50" alt="" onerror="this.onerror=null;this.src='{{$menu->item->img}}';">
                            </td>
                            <td>{{ $menu->item->name }}</td>
                            <td>{{ $menu->quantity }}</td>
                            <td>{{ 'Rp' . number_format($menu->item->price, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                        <tr>
                            <th colspan="4" class="text-end">Total:</th>
                            <th>{{ 'Rp' . number_format($order->subtotal, 0, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-end">Pajak:</th>
                            <th>{{ 'Rp' . number_format($order->tax, 0, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-end">Grand Total:</th>
                            <th>{{ 'Rp' . number_format($order->grand_total, 0, ',', '.') }}
                        </tr>
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