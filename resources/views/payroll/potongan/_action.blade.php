<td>
    @can('edit potongan')
        <a href="{{ route('potongan.edit', $model->id) }}" class="btn btn-primary btn-xs mb-1">
            <i class="fas fa-edit"></i>
        </a>
    @endcan
</td>
