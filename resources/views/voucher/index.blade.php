@extends('layouts.app',[
    'module_title'=> 'Voucher',
    'page_title'=> 'List Voucher',
    'page_url'=>'voucher'
])

@section('styles')
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endsection

@section('content')
<div class="row">

    <div class="col-12 col-sm-6 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">List Voucher</h3>
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
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
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
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        addTable();

        $('#table').on('click', '#delete', function(){
            const id = $(this).data('id');
            const title = "Hapus Banner";
            const message = "Apakah anda yakin ingin menghapus banner ini ?";
            const data = {
                id: id
            };
            const url = '{{ route('banner.destroy') }}';
            swal_confirm(title, message, url, data);

            return true;
        });

        $('#btn-search').click(function(){
            addTable();
        });

        function addTable(){
            const data = {
                search: $('#search').val(),
                status: $('#status').val(),
            };
            createTable(data, '{{ route('voucher.data') }}', '#table');
        }
    });
</script>
@endsection