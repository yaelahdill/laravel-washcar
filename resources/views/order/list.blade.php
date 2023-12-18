<div class="table-responsive">
    <table class="table table-sm table-bordered table-hover table-nowrap" id="datatable">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Invoice</th>
                <th>Merchant</th>
                <th>Customer</th>
                <th>Pembayaran</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody class="list fs-base">
            @forelse ($list as $item)
            <tr>
                <td>{{ $item->created_at->format('Y-m-d H:i:s') }}</td>
                <td>{{ $item->invoice }}</td>
                <td>{{ $item->merchant?->name }}</td>
                <td>{{ $item->user?->name }}</td>
                <td>{{ $item->payment?->payment_method }}</td>
                <td>Rp{{ number_format($item->total, 0, '.', '.') }}</td>
                <td>{{ $item->showStatus() }}</td>
                <td>
                    <a href="{{ route('order.view', $item)}}" class="btn btn-primary btn-sm">
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