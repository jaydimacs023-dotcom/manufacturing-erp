<div class="flex items-center space-x-2">
    @can('department-update')
        <x-button variant="secondary" size="sm" href="{{ route('admin.departments.edit', $department) }}">
            Edit
        </x-button>
    @endcan
    @can('department-delete')
        <form action="{{ route('admin.departments.destroy', $department) }}" method="POST"
              onsubmit="return confirm('Are you sure you want to delete this department?')">
            @csrf
            @method('DELETE')
            <x-button variant="danger" size="sm" type="submit">
                Delete
            </x-button>
        </form>
    @endcan
</div>

