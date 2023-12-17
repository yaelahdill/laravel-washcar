@extends('layouts.app',[
    'module_title'=> 'Dashboard',
    'page_title'=> 'Dashboard',
    'page_url'=>'dashboard'
])

@section('content')
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Customer</span>
                <span class="info-box-number">{{ $total_customer ?? "0" }} <small>Customer</small></span>
            </div>
        </div>    
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-store"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Merchant</span>
                <span class="info-box-number">{{ $total_merchant ?? "0" }} <small>Merchant</small></span>
            </div>
        </div>    
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-list"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Jumlah Layanan</span>
                <span class="info-box-number">{{ $total_service ?? "0" }} <small>Layanan</small></span>
            </div>
        </div>    
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-list"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Jumlah Voucher Aktif</span>
                <span class="info-box-number">{{ $total_voucher ?? "0" }} <small>Voucher</small></span>
            </div>
        </div>    
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-carts"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Jumlah Pesanan</span>
                <span class="info-box-number">{{ $jumlah_pesanan ?? "0" }} <small>Pesanan</small></span>
            </div>
        </div>    
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-carts"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Pesanan</span>
                <span class="info-box-number">{{ $total_pesanan ?? "0" }} <small>Rupiah</small></span>
            </div>
        </div>    
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-carts"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Pesanan Sukses</span>
                <span class="info-box-number">{{ $total_pesanan_sukses ?? "0" }} <small>Pesanan</small></span>
            </div>
        </div>    
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-carts"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Pesanan Proses</span>
                <span class="info-box-number">{{ $total_pesanan_proses ?? "0" }} <small>Pesanan</small></span>
            </div>
        </div>    
    </div>
    
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">5 Pesanan Terakhir</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Customer</th>
                            <th>Merchant</th>
                            <th>Layanan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($last_orders as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->user?->name }}</td>
                            <td>{{ $row->merchant?->name }}</td>
                            <td>
                                @foreach ($row->services as $service)
                                <li>{{ $service->name }}</li>
                                @endforeach
                            </td>
                            <td>{{ $row->created_at->format('Y-m-d H:i:s') }}</td>
                            <td>{{ $row->showStatus() }}</td>
                            <td>Rp{{ number_format($row->total, 0, '.', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection