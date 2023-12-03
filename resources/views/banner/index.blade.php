@extends('layouts.app',[
    'module_title'=> 'Banner',
    'page_title'=> 'List Banner',
    'page_url'=>'banner'
])

@section('styles')
<link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endsection

@section('content')
<div class="row">

    <div class="col-12 col-sm-6 col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">List Banner</h3>
            </div>
            <div class="card-body">
                <div id="table" class="mt-4"></div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-md-4">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Tambah Banner</h3>
            </div>
            <div class="card-body">
                <form>
                    <div class="form-group">
                        <label for="name">Nama Banner</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Nama Banner">
                    </div>
                    <div class="form-group">
                        <label for="image">Gambar Banner</label>
                        <input type="file" class="form-control" name="image" id="image" placeholder="Gambar Banner">
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
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        addTable();

        $('form').submit(function(e){
            const data = new FormData(this);
            const url = '{{ route('banner.store') }}';
            curl_post_image(url, data);

            return false;
        });

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
                
            };
            createTable(data, '{{ route('banner.data') }}', '#table');
        }
    });
</script>
@endsection