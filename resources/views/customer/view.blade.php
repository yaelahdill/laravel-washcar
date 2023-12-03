@extends('layouts.app',[
    'module_title'=> 'Customer',
    'page_title'=> 'Detail Customer',
    'page_url'=> 'customer'
])

@section('styles')
<link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-store"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Jumlah Pesanan</span>
                <span class="info-box-number">{{ $count_order }} <small>Pesanan</small></span>
            </div>
        </div>    
    </div>

    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-store"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Pesanan</span>
                <span class="info-box-number">{{ number_format($total_order, 0, '.', '.') }} <small>Rupiah</small></span>
            </div>
        </div>    
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Pesanan</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <label for="search">Search</label>
                        <input type="text" class="form-control" id="search" placeholder="Search">
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="date">Tanggal</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                </div>
                                <input type="text" class="form-control float-right" id="date">
                            </div>
                        </div>     
                    </div>                       
                    <div class="col-md-12">
                        <button class="btn btn-primary mt-2" id="btn-search">Search</button>
                    </div>
                </div>
                <div id="table" class="mt-4"></div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Detail Customer</h3>
            </div>
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" src="{{ asset('dist/img/user4-128x128.jpg') }}" alt="User profile picture">
                </div>
                <h3 class="profile-username text-center">{{ $customer->name }}</h3>
                {{-- <p class="text-muted text-center">{{ $merchant->address }}</p> --}}
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Email</b> <a class="float-right">{{ $customer->email }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Nomor Telepon</b> <a class="float-right">{{ $customer->phone }}</a>
                    </li>
                </ul>
            </div>                  
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<script>
    $(document).ready(function(){
        $('#date').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD',
                placeholder: 'Pilih tanggal',
                applyLabel: 'Pilih',
                cancelLabel: 'Batal',
            }
        });

        addTable();

        $('#btn-search').click(function(){
            addTable();
        });

        function addTable(){
            const data = {
                user_id: '{{ $customer->id }}',
                search: $('#search').val(),
                date: $('#date').val()
            };
            createTable(data, '{{ route('customer.data_order') }}', '#table');
        }
    });
</script>
@endsection