@extends('layouts.app')

@section('page-header', 'Edit Department')
@section('page-description', 'Update department information')

@section('content')
<div class="max-w-2xl">
    <x-card>
        <form action="{{ route('admin.departments.update', $department) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <x-input
                        label="Department Name"
                        name="department_name"
                        id="department_name"
                        :value="old('department_name', $department->department_name)"
                        required
                    />
                </div>

                <div>
                    <x-input
                        label="Department Code"
                        name="department_code"
                        id="department_code"
                        :value="old('department_code', $department->department_code)"
                        placeholder="Auto-generated if left blank"
                    />
                </div>

                <div>
                    <x-textarea
                        label="Description"
                        name="description"
                        id="description"
                        :value="old('description', $department->description)"
                        rows="3"
                    />
                </div>

                <div>
                    <x-checkbox
                        label="Active"
                        name="is_active"
                        id="is_active"
                        :checked="old('is_active', $department->is_active)"
                    />
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
                <x-button variant="secondary" href="{{ route('admin.departments.index') }}">
                    Cancel
                </x-button>
                <x-button variant="primary" type="submit">
                    Update Department
                </x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection

