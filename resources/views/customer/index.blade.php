@extends('layouts.app',[
    'module_title'=> 'Customer',
    'page_title'=> 'Customer',
    'page_url'=>'customer'
])

@section('content')
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Customer</span>
                <span class="info-box-number">{{ $total }} <small>Customer</small></span>
            </div>
        </div>    
    </div>
    
    <div class="col-12 col-sm-6 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">List Customer</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <label for="search">Search</label>
                        <input type="text" class="form-control" id="search" placeholder="Search">
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

        function addTable(){
            const data = {
                search: $('#search').val()
            };
            createTable(data, '{{ route('customer.data') }}', '#table');
        }
    });
</script>
@endsection