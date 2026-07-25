@extends('layouts.app')

@section('page-header', 'Create Department')
@section('page-description', 'Add a new organizational department')

@section('content')
<div class="max-w-2xl">
    <x-card>
        <form action="{{ route('admin.departments.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <x-input
                        label="Department Name"
                        name="department_name"
                        id="department_name"
                        :value="old('department_name')"
                        required
                        placeholder="e.g., Purchasing, Production, Quality Control"
                    />
                </div>

                <div>
                    <x-input
                        label="Department Code"
                        name="department_code"
                        id="department_code"
                        :value="old('department_code')"
                        placeholder="Auto-generated if left blank"
                    />
                </div>

                <div>
                    <x-textarea
                        label="Description"
                        name="description"
                        id="description"
                        :value="old('description')"
                        rows="3"
                        placeholder="Brief description of this department's function"
                    />
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
                <x-button variant="secondary" href="{{ route('admin.departments.index') }}">
                    Cancel
                </x-button>
                <x-button variant="primary" type="submit">
                    Create Department
                </x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection

