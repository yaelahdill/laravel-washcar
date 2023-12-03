@extends('layouts.app',[
    'module_title'=> 'Layanan',
    'page_title'=> 'Tambah Layanan',
    'page_url'=> 'service'
])

@section('styles')
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-list"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Layanan</span>
                <span class="info-box-number">{{ $total }} <small>Layanan</small></span>
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
                        <label class="col-form-label" for="name">Merchant</label>
                        <select class="form-control" id="merchant_id">
                            @foreach($merchants as $row)
                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="name">Nama</label>
                        <input type="text" class="form-control" id="name" placeholder="Nama Layanan">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="category">Jenis Kendaraan</label>
                        <select class="form-control" id="category">
                            <option value="Motor">Motor</option>
                            <option value="Mobil">Mobil</option>
                        </select>   
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="type">Type</label>
                        <select class="form-control" id="type">
                            <option value="Kecil">Kecil</option>
                            <option value="Sedang">Sedang</option>
                            <option value="Besar">Besar</option>
                        </select>   
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="description">Deskripsi</label>
                        <textarea class="form-control" rows="4" id="description" placeholder="Deskripsi Layanan"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="estimation">Estimasi</label>
                        <input type="text" class="form-control" id="estimation" placeholder="Contoh : 1 - 2 Jam">
                    </div>
                    <div class="form-group">
                        <label class="col-form-label" for="price">Harga</label>
                        <input type="text" class="form-control" id="price" placeholder="Harga Layanan">
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
<script src="{{ asset('plugins/inputmask/jquery.inputmask.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#price').inputmask("currency", {
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
                merchant_id: $('#merchant_id').val(),
                name: $('#name').val(),
                category: $('#category').val(),
                type: $('#type').val(),
                description: $('#description').val(),
                estimation: $('#estimation').val(),
                price: $('#price').val()
            };
            const url = "{{ route('service.store') }}";
            curl_post(url, data);
            e.preventDefault();
        });
    });
</script>
@endsection