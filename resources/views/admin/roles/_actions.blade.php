<div class="flex items-center space-x-2">
    @can('role-update')
        <x-button variant="secondary" size="sm" href="{{ route('admin.roles.edit', $role) }}">
            Edit
        </x-button>
    @endcan
    @can('role-delete')
        <form action="{{ route('admin.roles.destroy', $role) }}" method="POST"
              onsubmit="return confirm('Are you sure you want to delete this role?')">
            @csrf
            @method('DELETE')
            <x-button variant="danger" size="sm" type="submit">
                Delete
            </x-button>
        </form>
    @endcan
</div>

