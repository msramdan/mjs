<td>
    @can('edit benefit')
        <a href="{{ route('benefit.edit', $model->id) }}" class="btn btn-primary btn-xs mb-1">
            <i class="fas fa-edit"></i>
        </a>
    @endcan
</td>
