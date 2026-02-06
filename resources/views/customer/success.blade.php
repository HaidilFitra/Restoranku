@extends('customer.layouts.master')
@section('title', 'Pesanan Berhasil')
@section('content')
<div class="container-fluid d-flex justify-content-center py-5">
  <div class="receipt border p-4 bg-white shadow" style="width: 450px; margin-top: 5rem;">
    <h5 class="text-center mb-2">Pesanan Berhasil Dibuat!</h5>
    @if ($order->payment_method == 'tunai' && $order->status == 'pending')
      <p class="text-center"><span class="badge bg-danger">Menunggu Pembayaran</span></p>
    @elseif ($order->payment_method == 'qris' && $order->status == 'pending')
      <p class="text-center"><span class="badge bg-danger">Menunggu Konfirmasi Pembayaran</span></p>
    @else
      <p class="text-center"><span class="badge bg-success">Pembayaran berhasil, Pesanan segera diproses</span></p>
    @endif
    <hr>
    <h4 class="fw-bold text-center">Kode bayar <br> <span class="text-primary">{{ $order->order_code }}</span></h4>
    <hr>
    <h5 class="mb-3 text-center">Detail Pesanan</h5>
    <table class="table table-borderless">
      <tbody>
        @foreach ($orderItems as $orderItem)
          <tr>
            <td>{{ Str::limit($orderItem->item->name, 25) }} ({{$orderItem->quantity}})</td>
            <td class="text-end">{{ 'Rp'. number_format($orderItem->price,0,',','.') }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <table class="table table-borderless">
      <tbody>
        <tr>
          <th>Subtotal:</th>
          <th class="text-end">{{ 'Rp'. number_format($order->subtotal,0,',','.') }}</th>
        </tr>
        <tr>
          <th>Pajak (10%):</th>
          <th class="text-end">{{ 'Rp'. number_format($order->tax,0,',','.') }}</th>
        </tr>
        <tr>
          <th>Total:</th>
          <th class="text-end">{{ 'Rp'. number_format($order->grand_total,0,',','.') }}</th>
        </tr>
      </tbody>
    </table>
    @if($order->payment_method == 'tunai')
      <p class="small text-center">Silakan lakukan pembayaran tunai kepada pelayan kami saat pesanan Anda tiba.</p>
      @elseif($order->payment_method == 'qris')
      <p class="small text-center">Yeay! Pembayaran sukses. Duduk manis ya, Pesanan kamu segera kami proses.</p>
      @endif
      <hr>
      <a href="{{ route('menu') }}" class="btn btn-primary w-100">Kembali ke Menu</a>
  </div>
</div>
@endsection