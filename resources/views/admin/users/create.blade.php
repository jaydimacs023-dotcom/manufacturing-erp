@extends('layouts.app')

@section('page-header', 'Create User')
@section('page-description', 'Add a new system user')

@section('content')
<div class="max-w-2xl">
    <x-card>
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <x-input
                        label="Full Name"
                        name="name"
                        id="name"
                        :value="old('name')"
                        required
                        placeholder="John Doe"
                    />
                </div>

                <div>
                    <x-input
                        label="Email Address"
                        name="email"
                        id="email"
                        type="email"
                        :value="old('email')"
                        required
                        placeholder="john@example.com"
                    />
                </div>

                <div>
                    <x-input
                        label="Password"
                        name="password"
                        id="password"
                        type="password"
                        required
                        placeholder="Min. 8 characters"
                    />
                </div>

                <div>
                    <x-select
                        label="Branch"
                        name="branch_id"
                        id="branch_id"
                        :options="$branches->pluck('branch_name', 'id')"
                        :selected="old('branch_id')"
                        placeholder="Select Branch"
                    />
                </div>

                <div>
                    <x-select
                        label="Department"
                        name="department_id"
                        id="department_id"
                        :options="$departments->pluck('department_name', 'id')"
                        :selected="old('department_id')"
                        placeholder="Select Department"
                    />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Roles</label>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach($roles as $role)
                            <label class="flex items-center space-x-2 p-2 rounded hover:bg-gray-50">
                                <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                       {{ in_array($role->id, old('roles', [])) ? 'checked' : '' }}>
                                <span class="text-sm text-gray-700">{{ $role->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div>
                    <x-checkbox
                        label="Active"
                        name="is_active"
                        id="is_active"
                        :checked="old('is_active', true)"
                    />
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
                <x-button variant="secondary" href="{{ route('admin.users.index') }}">
                    Cancel
                </x-button>
                <x-button variant="primary" type="submit">
                    Create User
                </x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection

