<div class="table-responsive">
    <table class="table table-sm table-bordered table-hover table-nowrap" id="datatable">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kendaraan</th>
                <th>Ukuran</th>
                <th>Description</th>
                <th>Estimasi</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody class="list fs-base">
            @forelse ($list as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->vehicle_category }}</td>
                <td>{{ $item->vehicle_size }}</td>
                <td>{{ $item->description }}</td>
                <td>{{ $item->estimated_time }}</td>
                <td>Rp{{ number_format($item->price, 0, '.', '.') }}</td>
                <td>
                    <button id="delete" class="btn btn-danger btn-sm" data-id="{{ $item->id }}">
                        <i class="fas fa-trash"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">No data found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>