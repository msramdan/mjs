<td>
    @can('view item')
        <a href="{{ route('item.tracking', $model->id) }}" class="btn btn-success btn-xs mb-1">
            <i class="fas fa-calculator"></i>
        </a>
    @endcan

    @can('edit item')
        <a href="{{ route('item.edit', $model->id) }}" class="btn btn-primary btn-xs mb-1">
            <i class="fas fa-edit"></i>
        </a>
    @endcan

    @can('delete item')
        <form action="{{ route('item.destroy', $model->id) }}" method="post" class="d-inline"
            onsubmit="return confirm('Yakin ingin menghapus data ini?')">
            @csrf
            @method('delete')

            <button class="btn btn-danger btn-xs mb-1">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>
    @endcan
</td>
