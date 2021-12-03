<td>
    <a href="{{ route('supplier.edit', $model->id) }}" class="btn btn-primary btn-sm mb-1">
        <i class="fas fa-edit"></i>
    </a>

    <form action="{{ route('supplier.destroy', $model->id) }}" method="post" class="d-inline"
        onsubmit="return confirm('Yakin ingin menghapus data ini?')">
        @csrf
        @method('delete')

        <button class="btn btn-danger btn-sm mb-1">
            <i class="fas fa-trash"></i>
        </button>
    </form>
</td>
