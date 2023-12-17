@extends('layouts.app',[
    'module_title'=> 'Voucher',
    'page_title'=> 'Tambah Voucher',
    'page_url'=> 'voucher'
])

@section('styles')
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endsection

@section('content')
<div class="row">
    {{-- <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-store"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Merchant</span>
                <span class="info-box-number">{{ $total }} <small>Merchant</small></span>
            </div>
        </div>    
    </div> --}}
    
    <div class="col-12 col-sm-6 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tambah Voucher</h3>
            </div>
            <div class="card-body">
                <form method="post">
                    <div class="form-group">
                        <label class="col-form-label" for="merchant">Merchant</label>
                        <select class="form-control" id="merchant" required>
                            <option value="">Pilih Merchant</option>
                            @foreach ($merchants as $merchant)
                            <option value="{{ $merchant->id }}">{{ $merchant->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nama Voucher</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama Voucher" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="code">Kode Voucher</label>
                        <input type="text" class="form-control" id="code" placeholder="Kode Voucher" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="description">Deskripsi</label>
                        <textarea class="form-control" id="description" placeholder="Deskripsi" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="amount">Total Discount</label>
                        <input type="text" class="form-control" id="amount" placeholder="Total Discount" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="start_date">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="start_date" placeholder="Tanggal Mulai" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="end_date">Tanggal Berakhir</label>
                        <input type="date" class="form-control" id="end_date" placeholder="Tanggal Berakhir" required>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="quantity">Jumlah Voucher</label>
                        <input type="number" class="form-control" id="quantity" placeholder="Jumlah Voucher" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#amount').inputmask("currency", {
            radixPoint: ",",
            groupSeparator: ".",
            digits: 0,
            autoGroup: true,
            prefix: 'Rp ', //Space after $, this will not truncate the first character.
            rightAlign: false,
            oncleared: function () { self.Value(''); }
        });

        $('form').submit(function(e){
            const data = {
                merchant_id: $('#merchant').val(),
                name: $('#name').val(),
                code: $('#code').val(),
                description: $('#description').val(),
                amount: $('#amount').val(),
                start_date: $('#start_date').val(),
                end_date: $('#end_date').val(),
                quantity: $('#quantity').val(),
            };
            const url = "{{ route('voucher.store') }}";
            curl_post(url, data);
            e.preventDefault();
        });
    });
</script>
@endsection