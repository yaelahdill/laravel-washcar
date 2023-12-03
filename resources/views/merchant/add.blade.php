@extends('layouts.app',[
    'module_title'=> 'Merchant',
    'page_title'=> 'Add Merchant',
    'page_url'=> 'merchant'
])

@section('styles')
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-store"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Merchant</span>
                <span class="info-box-number">{{ $total }} <small>Merchant</small></span>
            </div>
        </div>    
    </div>
    
    <div class="col-12 col-sm-6 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tambah Merchant</h3>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <label class="col-form-label" for="name">Nama</label>
                        <input type="text" class="form-control" id="name" placeholder="Nama Merchant">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="phone">Nomor Telepon</label>
                        <input type="number" class="form-control" id="phone" placeholder="Nomor Telepon Merchant">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="email">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="Email Merchant">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="address">Alamat</label>
                        <textarea class="form-control" rows="4" id="address" placeholder="Alamat Merchant"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="city">Kota</label>
                        <input type="text" class="form-control" id="city" placeholder="Kota Merchant">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="opening">Jam Operasional</label>
                        <input type="text" class="form-control" id="opening" placeholder="Contoh : 08:00 - 22:00">
                    </div>
                    <div class="form-group">
                        <button type="submit" id="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('form').submit(function(e){
            const data = {
                name: $('#name').val(),
                phone: $('#phone').val(),
                email: $('#email').val(),
                address: $('#address').val(),
                city: $('#city').val(),
                opening_hours: $('#opening').val(),
                csrf_token: $('meta[name="csrf-token"]').attr('content')
            };
            const url = "{{ route('merchant.store') }}";
            curl_post(url, data);
            e.preventDefault();
        });
    });
</script>
@endsection