@extends('layouts.app')

@section('page-header', 'Edit Branch')
@section('page-description', 'Update branch information')

@section('content')
<div class="max-w-2xl">
    <x-card>
        <form action="{{ route('admin.branches.update', $branch) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <x-input label="Branch Name" name="branch_name" id="branch_name" :required="true" value="{{ old('branch_name', $branch->branch_name) }}" />
                <x-input label="Branch Code" name="branch_code" id="branch_code" value="{{ old('branch_code', $branch->branch_code) }}" />
                <x-input label="Contact Number" name="contact_number" id="contact_number" value="{{ old('contact_number', $branch->contact_number) }}" />
                <x-textarea label="Address" name="address" id="address">{{ old('address', $branch->address) }}</x-textarea>
                <x-checkbox label="Active" name="is_active" id="is_active" :checked="old('is_active', $branch->is_active)" />
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.branches.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Update Branch</x-button>
            </div>
        </form>
    </x-card>

