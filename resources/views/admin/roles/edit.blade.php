@extends('layouts.app')

@section('page-header', 'Edit Role')
@section('page-description', 'Update role name and permissions')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.roles.update', $role) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <x-input
                    label="Role Name"
                    name="name"
                    id="name"
                    :value="old('name', $role->name)"
                    required
                    placeholder="e.g., Production Supervisor, Quality Inspector"
                />
            </div>

            <div class="mb-4">
                <h3 class="text-sm font-medium text-gray-700 mb-3">Permissions</h3>
                <div class="space-y-4">
                    @foreach($permissions as $group => $groupPermissions)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="text-sm font-semibold text-gray-800 uppercase tracking-wider mb-3">
                                {{ $group }}
                            </h4>
                            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2">
                                @foreach($groupPermissions as $permission)
                                    <label class="flex items-center space-x-2 text-sm">
                                        <input type="checkbox"
                                               name="permissions[]"
                                               value="{{ $permission->id }}"
                                               {{ in_array($permission->id, old('permissions', $rolePermissions)) ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <span>{{ $permission->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
                <x-button variant="secondary" href="{{ route('admin.roles.index') }}">
                    Cancel
                </x-button>
                <x-button variant="primary" type="submit">
                    Update Role
                </x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection

