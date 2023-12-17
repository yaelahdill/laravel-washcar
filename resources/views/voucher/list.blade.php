<div class="table-responsive">
    <table class="table table-sm table-bordered table-hover table-nowrap" id="datatable">
        <thead>
            <tr>
                <th>No</th>
                <th>Merchant</th>
                <th>Nama</th>
                <th>Kode Voucher</th>
                <th>Deskripsi</th>
                <th>Diskon</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Berakhir</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody class="list fs-base">
            @forelse ($list as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->merchant?->name }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->code }}</td>
                <td>{{ $item->description }}</td>
                <td>Rp{{ number_format($item->discount, 0, '.', '.') }}</td>
                <td>{{ $item->start_date }}</td>
                <td>{{ $item->expired_at }}</td>
                <td>
                    @if ($item->is_active == 1)
                    <span class="badge badge-success">Aktif</span>
                    @else
                    <span class="badge badge-danger">Tidak Aktif</span>
                    @endif
                </td>
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