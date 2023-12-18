@extends('layouts.app',[
    'module_title'=> 'Order',
    'page_title'=> 'List Order',
    'page_url'=> 'order'
])

@section('styles')
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endsection


@section('content')
<div class="row">
    <div class="col-12 col-sm-6 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">List Order</h3>
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
            $('#category').val('');
            addTable();
        });

        function addTable(){
            const data = {
                merchant_id: $('#merchant_id').val(),
                search: $('#search').val(),
            };
            createTable(data, '{{ route('order.data') }}', '#table');
        }
    });
</script>
@endsection