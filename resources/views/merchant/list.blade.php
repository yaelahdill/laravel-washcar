<div class="table-responsive">
    <table class="table table-sm table-bordered table-hover table-nowrap" id="datatable">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Nomor Telepon</th>
                <th>Email</th>
                <th>Alamat</th>
                <th>Kota</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody class="list fs-base">
            @forelse ($list as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->phone }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->address }}</td>
                <td>{{ $item->city }}</td>
                <td>
                    <a href="{{ route('merchant.view', $item) }}" class="btn btn-primary btn-sm">
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