<div class="table-responsive">
    <table class="table table-sm table-bordered table-hover table-nowrap" id="datatable">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody class="list fs-base">
            @forelse ($list as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->title }}</td>
                <td><a href="{{ asset('images/banner/' . $item->image) }}" target="_blank">{{ $item->image }}</a></td>
                <td>
                    <button id="delete" class="btn btn-danger btn-sm" data-id="{{ $item->id }}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center">No data found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>