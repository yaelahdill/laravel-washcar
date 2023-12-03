<div class="table-responsive">
    <table class="table table-sm table-bordered table-hover table-nowrap" id="datatable">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Type</th>
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
                <td>{{ $item->type }}</td>
                <td>{{ $item->description }}</td>
                <td>{{ $item->estimated_time }}</td>
                <td>Rp{{ number_format($item->price, 0, '.', '.') }}</td>
                <td>
                    <a href="" class="btn btn-primary btn-sm">
                        <i class="fas fa-eye"></i>
                    </a>
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