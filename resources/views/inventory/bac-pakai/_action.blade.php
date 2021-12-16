<td>
    <a href="{{ route('bac-pakai.show', $model->id) }}" class="btn btn-info btn-xs mb-1">
        <i class="fas fa-eye"></i>
    </a>

    <a href="{{ route('bac-pakai.edit', $model->id) }}" class="btn btn-primary btn-xs mb-1">
        <i class="fas fa-edit"></i>
    </a>

    <form action="{{ route('bac-pakai.destroy', $model->id) }}" method="post" class="d-inline"
        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
        @csrf
        @method('delete')

        <button class="btn btn-danger btn-xs mb-1">
            <i class="fas fa-trash-alt"></i>
        </button>
    </form>
</td>
