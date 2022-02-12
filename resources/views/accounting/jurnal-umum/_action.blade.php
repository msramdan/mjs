<td>
    {{-- @can('edit jurnal umum') --}}
    <a href="{{ route('jurnal-umum.edit', $model->id) }}" class="btn btn-primary btn-xs mb-1">
        <i class="fas fa-edit"></i>
    </a>
    {{-- @endcan --}}

    {{-- @can('delete jurnal umum') --}}
    {{-- <form action="{{ route('jurnal-umum.destroy', $model->id) }}" method="post" class="d-inline"
            onsubmit="return confirm('Yakin ingin menghapus data ini?')">
            @csrf
            @method('delete')

            <button class="btn btn-danger btn-xs mb-1">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form> --}}
    {{-- @endcan --}}
</td>
