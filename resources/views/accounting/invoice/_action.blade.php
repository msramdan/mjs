<td>
    @can('view invoice')
        <a href="{{ route('invoice.show', $model->id) }}" class="btn btn-info btn-xs mb-1">
            <i class="fas fa-eye"></i>
        </a>

        <a href="{{ route('invoice.print', $model->id) }}" class="btn btn-dark btn-xs mb-1" target="_blank">
            <i class="fas fa-print"></i>
        </a>
    @endcan

    @can('edit invoice')
        @if ($model->status == 'Unpaid')
            <a href="{{ route('invoice.edit', $model->id) }}" class="btn btn-primary btn-xs mb-1">
                <i class="fas fa-edit"></i>
            </a>
        @endif
    @endcan

    @can('delete invoice')
        @if ($model->status == 'Unpaid')
            <form action="{{ route('invoice.destroy', $model->id) }}" method="post" class="d-inline"
                onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                @csrf
                @method('delete')

                <button class="btn btn-danger btn-xs mb-1">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </form>
        @endif
    @endcan
</td>
