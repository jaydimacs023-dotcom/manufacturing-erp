<div class="flex items-center space-x-2">
    @can('view', $user)
        <x-button variant="secondary" size="sm" href="{{ route('admin.users.show', $user) }}">
            View
        </x-button>
    @endcan
    @can('update', $user)
        <x-button variant="secondary" size="sm" href="{{ route('admin.users.edit', $user) }}">
            Edit
        </x-button>
    @endcan
    @can('delete', $user)
        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
              onsubmit="return confirm('Are you sure you want to delete this user?')">
            @csrf
            @method('DELETE')
            <x-button variant="danger" size="sm" type="submit">
                Delete
            </x-button>
        </form>
    @endcan
</div>

