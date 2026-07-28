@extends('layouts.app')

@section('page-header', 'Create Role')
@section('page-description', 'Define a new role with permissions')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <x-input
                    label="Role Name"
                    name="name"
                    id="name"
                    :value="old('name')"
                    required
                    placeholder="e.g., Purchasing Officer, Production Supervisor"
                />
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Permissions</h3>

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
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span>{{ $permission->name }}</span>
</label>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="flex items-center justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
                <x-button variant="secondary" href="{{ route('admin.roles.index') }}">
                    Cancel
                </x-button>
                <x-button variant="primary" type="submit">
                    Create Role
                </x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
