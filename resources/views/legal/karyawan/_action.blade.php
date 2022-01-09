<td>
    @can('upload berkas karyawan')
        <a href="{{ route('berkas-karyawan.create') }}?karyawan={{ $model->id }}" class="btn btn-info btn-xs mb-1">
            <i class="fas fa-upload"></i>
        </a>
    @endcan

    @can('edit karyawan')
        <a href="{{ route('karyawan.edit', $model->id) }}" class="btn btn-primary btn-xs mb-1">
            <i class="fas fa-edit"></i>
        </a>
    @endcan

    @can('delete karyawan')
        <form action="{{ route('karyawan.destroy', $model->id) }}" method="post" class="d-inline"
            onsubmit="return confirm('Yakin ingin menghapus data ini?')">
            @csrf
            @method('delete')

            <button class="btn btn-danger btn-xs mb-1">
                <i class="fas fa-trash-alt"></i>
            </button>
        </form>
    @endcan
</td>
