<td>
    @can('view invoice')
        <a href="{{ route('invoice.show', $model->id) }}" class="btn btn-info btn-xs mb-1">
            <i class="fas fa-eye"></i>
        </a>
    @endcan

    @can('edit invoice')
        <a href="{{ route('invoice.edit', $model->id) }}" class="btn btn-primary btn-xs mb-1">
            <i class="fas fa-edit"></i>
        </a>
    @endcan

    @can('delete invoice')
        <form action="{{ route('invoice.destroy', $model->id) }}" method="post" class="d-inline"
            onsubmit="return confirm('Yakin ingin menghapus data ini?')">
            @csrf
            @method('delete')

            <button class="btn btn-danger btn-xs mb-1">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>
    @endcan
</td>
