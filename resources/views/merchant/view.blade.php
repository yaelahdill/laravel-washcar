@extends('layouts.app',[
    'module_title'=> 'Merchant',
    'page_title'=> 'Detail Merchant',
    'page_url'=> 'merchant'
])

@section('styles')
<link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
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

    <!--Modal -->
    <div class="modal fade" id="modal-update">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Merchant</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label class="col-form-label" for="name">Nama</label>
                            <input type="text" class="form-control" id="name" placeholder="Nama Merchant" value="{{ $merchant->name }}" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="phone">Nomor Telepon</label>
                            <input type="number" class="form-control" id="phone" placeholder="Nomor Telepon Merchant" value="{{ $merchant->phone }}" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="phone">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Email Merchant" value="{{ $merchant->email }}" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Alamat</label>
                            <textarea class="form-control" id="address" rows="3" placeholder="Alamat Merchant" required>{!! $merchant->address !!}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="city">Kota</label>
                            <input type="text" class="form-control" id="city" placeholder="Kota Merchant" value="{{ $merchant->city }}" required>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="opening">Jam Operasional</label>
                            <input type="text" class="form-control" id="opening" placeholder="Contoh : 08-00 : 23:00" value="{{ $merchant->opening_hours }}" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save-update">Save changes</button>
                </div>
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
                    <div class="col-md-3">
                        <label for="search">Search</label>
                        <input type="text" class="form-control" id="search" placeholder="Search">
                    </div>
                    <div class="col-md-3">
                        <label for="status">Status</label>
                        <select class="form-control" id="status">
                            <option value="">Semua</option>
                            <option value="1">Belum Bayar</option>
                            <option value="2">Sudah Bayar</option>
                            <option value="3">Dalam Proses</option>
                            <option value="4">Selesai</option>
                            <option value="5">Dibatalkan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
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
                <h3 class="card-title">Detail Merchant</h3>
            </div>
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" src="{{ asset('dist/img/user4-128x128.jpg') }}" alt="User profile picture">
                </div>
                <h3 class="profile-username text-center">{{ $merchant->name }}</h3>
                <p class="text-muted text-center">{{ $merchant->address }}</p>
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Email</b> <a class="float-right">{{ $merchant->email }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Nomor Telepon</b> <a class="float-right">{{ $merchant->phone }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Kota</b> <a class="float-right">{{ $merchant->city }}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Jam Operasional</b> <a class="float-right">{{ $merchant->opening_hours }}</a>
                    </li>
                </ul>
                <button type="button" data-toggle="modal" data-target="#modal-update" class="btn btn-primary btn-block"><b>Edit Merchant</b></button>
            </div>                  
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
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

        const start_date = moment().startOf('month').format('YYYY-MM-DD');
        const end_date = moment().endOf('month').format('YYYY-MM-DD');
        $('#date').val(start_date + ' - ' + end_date);

        addTable();

        $('#btn-search').click(function(){
            addTable();
        });

        $('#save-update').click(function(e){
            const data = {
                id: '{{ $merchant->id }}',
                name: $('#name').val(),
                phone: $('#phone').val(),
                email: $('#email').val(),
                address: $('#address').val(),
                city: $('#city').val(),
                opening_hours: $('#opening').val(),
            }
            const url = '{{ route('merchant.update') }}';
            curl_post(url, data);

            return false;
        });
        

        function addTable(){
            const data = {
                merchant_id: '{{ $merchant->id }}',
                search: $('#search').val(),
                date: $('#date').val(),
                status: $('#status').val(),
            };
            createTable(data, '{{ route('merchant.data_order') }}', '#table');
        }
    });
</script>
@endsection