<td>
    @can('view request form purchase')
        <a href="{{ route('request-form.show', $model->id) }}" class="btn btn-info btn-xs mb-1" title="Detail">
            <i class="fas fa-eye"></i>
        </a>
    @endcan

    @can('edit request form purchase')
        <a href="{{ route('request-form.edit', $model->id) }}" class="btn btn-primary btn-xs mb-1" title="Edit">
            <i class="fas fa-edit"></i>
        </a>
    @endcan

    @can('delete request form purchase')
        <form action="{{ route('request-form.destroy', $model->id) }}" method="post" class="d-inline"
            onsubmit="return confirm('Yakin ingin menghapus data ini?')" title="Delete">
            @csrf
            @method('delete')

            <button class="btn btn-danger btn-xs mb-1">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>
    @endcan
</td>
