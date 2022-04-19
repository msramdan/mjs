<td>
    @role('gm')
        @if ($model->grand_total > 10000000 && $model->approve_by_direktur == null)
            <a href="#" class="btn btn-dark btn-xs mb-1 disabled" title="Approve">
                <i class="fas fa-check"></i>
            </a>
        @elseif ($model->approve_by_gm == null)
            <a href="{{ route('purchase.approve', $model->id) }}" class="btn btn-dark btn-xs mb-1 " title="Approve">
                <i class="fas fa-check"></i>
            </a>
        @elseif ($model->approve_by_gm != null)
            <a href="#" class="btn btn-dark btn-xs mb-1 disabled" title="Approve">
                <i class="fas fa-check"></i>
            </a>
        @else
            <a href="#" class="btn btn-dark btn-xs mb-1 disabled" title="Approve">
                <i class="fas fa-check"></i>
            </a>
        @endif
    @endrole

    @role('direktur')
        <a href="{{ route('purchase.approve', $model->id) }}"
            class="btn btn-dark btn-xs mb-1{{ ($model->grand_total < 10000000 ? ' disabled' : $model->approve_by_direktur != null) ? ' disabled' : '' }}"
            title="Approve">
            <i class="fas fa-check"></i>
        </a>
    @endrole

    @can('view purchase')
        <a href="{{ route('purchase.show', $model->id) }}" class="btn btn-info btn-xs mb-1" title="Detail">
            <i class="fas fa-eye"></i>
        </a>
    @endcan

    @can('edit purchase')
        <a href="{{ route('purchase.edit', $model->id) }}" class="btn btn-primary btn-xs mb-1" title="Edit">
            <i class="fas fa-edit"></i>
        </a>
    @endcan

    @can('delete purchase')
        <form action="{{ route('purchase.destroy', $model->id) }}" method="post" class="d-inline"
            onsubmit="return confirm('Yakin ingin menghapus data ini?')">
            @csrf
            @method('delete')

            <button class="btn btn-danger btn-xs mb-1" title="Delete">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>
    @endcan
</td>
