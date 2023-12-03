@extends('layouts.app',[
    'module_title'=> 'Layanan',
    'page_title'=> 'Layanan',
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
                <span class="info-box-text">Jumlah Layanan</span>
                <span class="info-box-number">{{ $total }} <small>Layanan</small></span>
            </div>
        </div>    
    </div>
    
    <div class="col-12 col-sm-6 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">List Layanan</h3>
                <div class="card-tools">
                    <a href="{{ route('service.add') }}" class="btn btn-primary btn-sm">Tambah Layanan</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="search">Search</label>
                        <input type="text" class="form-control" placeholder="Search..." id="search">
                    </div>
                    <div class="col-md-3">
                        <label for="search">Merchant</label>
                        <select class="form-control" id="merchant_id">
                            @foreach($merchants as $row)
                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-primary mt-2" id="btn-search">Search</button>
                        <button class="btn btn-danger mt-2" id="btn-reset">Reset</button>
                    </div>
                </div>
                <div id="table" class="mt-4"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        addTable();

        $('#btn-search').click(function(){
            addTable();
        });

        $('#btn-reset').click(function(){
            $('#search').val('');
            addTable();
        });

        $('#table').on('click', '#delete', function(){
            const id = $(this).data('id');
            const title = "Hapus Layanan";
            const message = "Apakah anda yakin ingin menghapus layanan ini ?";
            const data = {
                id: id
            };
            const url = '{{ route('service.destroy') }}';
            swal_confirm(title, message, url, data);

            return true;
        });

        function addTable(){
            const data = {
                merchant_id: $('#merchant_id').val(),
                search: $('#search').val()
            };
            createTable(data, '{{ route('service.data') }}', '#table');
        }
    });
</script>
@endsection