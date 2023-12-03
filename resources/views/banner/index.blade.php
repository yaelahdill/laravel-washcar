@extends('layouts.app',[
    'module_title'=> 'Banner',
    'page_title'=> 'List Banner',
    'page_url'=>'banner'
])

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
                        <input type="text" class="form-control" id="name" placeholder="Nama Banner">
                    </div>
                    <div class="form-group">
                        <label for="image">Gambar Banner</label>
                        <input type="file" class="form-control" id="image" placeholder="Gambar Banner">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
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
                search: $('#search').val()
            };
            createTable(data, '{{ route('merchant.data') }}', '#table');
        }
    });
</script>
@endsection