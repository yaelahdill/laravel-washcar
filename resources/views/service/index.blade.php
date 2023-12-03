@extends('layouts.app',[
    'module_title'=> 'Layanan',
    'page_title'=> 'Layanan',
    'page_url'=> 'service'
])

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
                    <div class="col-md-4">
                        <label for="search">Merchant</label>
                        <select class="form-control" id="merchant_id">
                            @foreach($merchants as $row)
                            <option value="{{ $row->id }}">{{ $row->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <button class="btn btn-primary mt-2" id="btn-search">Search</button>
                    </div>
                </div>
                <div id="table" class="mt-4"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        addTable();

        $('#btn-search').click(function(){
            addTable();
        });

        function addTable(){
            const data = {
                merchant_id: $('#merchant_id').val()
            };
            createTable(data, '{{ route('service.data') }}', '#table');
        }
    });
</script>
@endsection