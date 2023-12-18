@extends('layouts.app',[
    'module_title'=> 'Detail Order',
    'page_title'=> 'View Order',
    'page_url'=> 'order'
])

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Detail Pesanan</div>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Invoice</b> <b class="float-right">{{ strtoupper($order->invoice) }}</b>
                    </li>
                    <li class="list-group-item">
                        <b>Tanggal Pesanan</b> <b class="float-right">{{ strtoupper($order->created_at->format('Y-m-d H:i:s')) }}</b>
                    </li>
                    <li class="list-group-item">
                        <b>Status Pesanan</b> <b class="float-right">
                            @if (in_array($order->status, [1, 5]))
                            <span class="badge badge-danger">{{ $order->showStatus() }}</span>
                            @elseif (in_array($order->status, [2,3]))
                            <span class="badge badge-primary">{{ $order->showStatus() }}</span>
                            @elseif ($order->status == '4')
                            <span class="badge badge-success">{{ $order->showStatus() }}</span>
                            @else
                            <span class="badge badge-danger">{{ $order->showStatus() }}</span>
                            @endif
                        </b>
                    </li>
                    <li class="list-group-item">
                        <b>Nama Customer</b> <b class="float-right">{{ strtoupper($order->user?->name) }}</b>
                    </li>
                    <li class="list-group-item">
                        <b>Nomor Telepon Customer</b> <b class="float-right">{{ strtoupper($order->user?->phone) }}</b>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Detail Merchant</div>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Nama</b> <b class="float-right">{{ $order->merchant?->name }}</b>
                    </li>
                    <li class="list-group-item">
                        <b>Email</b> <b class="float-right">{{ $order->merchant?->email }}</b>
                    </li>
                    <li class="list-group-item">
                        <b>Alamat</b> <b class="float-right">{{ $order->merchant?->address }}</b>
                    </li>
                    <li class="list-group-item">
                        <b>Kota</b> <b class="float-right">{{ $order->merchant?->city }}</b>
                    </li>
                    <li class="list-group-item">
                        <b>Jam Operasional</b> <b class="float-right">{{ $order->merchant?->opening_hours }}</b>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Detail Kendaraan</div>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Tipe Kendaraan</b> <b class="float-right">{{ $order->vehicle?->category }}</b>
                    </li>
                    <li class="list-group-item">
                        <b>Brand</b> <b class="float-right">{{ $order->vehicle?->brand }}</b>
                    </li>
                    <li class="list-group-item">
                        <b>Plat Nomor</b> <b class="float-right">{{ $order->vehicle?->plate_number }}</b>
                    </li>
                    <li class="list-group-item">
                        <b>Ukuran</b> <b class="float-right">{{ $order->vehicle?->size }}</b>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Layanan Dipesan</div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <th>Nama</th>
                            <th>Deskripsi</th>
                            <th>Estimasi</th>
                            <th>Harga</th>
                        </thead>
                        <tbody>
                            @foreach ($order->services as $service)
                            <tr>
                                <td>{{ $service->name }}</td>
                                <td>{{ $service->description }}</td>
                                <td>{{ $service->estimated_time }}</td>
                                <td>Rp{{ number_format($service->price, 0, '.', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3">Subtotal</th>
                                <th>Rp{{ number_format($order->subtotal, 0, '.', '.') }}</th>
                            </tr>
                            <tr>
                                <th colspan="3">Diskon</th>
                                <th>-Rp{{ number_format($order->discount, 0, '.', '.') }}</th>
                            </tr>
                            <tr>
                                <th colspan="3">Total</th>
                                <th>Rp{{ number_format($order->total, 0, '.', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Pembayaran</div>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Metode Pembayaran</b> <b class="float-right">{{ strtoupper($order->payment?->payment_method) }}</b>
                    </li>
                    <li class="list-group-item">
                        <b>Nama Pembayaran</b> <b class="float-right">{{ strtoupper($order->payment?->payment_name) }}</b>
                    </li>
                    <li class="list-group-item">
                        <b>Transaction ID</b> <b class="float-right">{{ strtoupper($order->payment?->transaction_id) }}</b>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection