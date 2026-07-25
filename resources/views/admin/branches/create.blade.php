@extends('layouts.app')

@section('page-header', 'Create Branch')
@section('page-description', 'Add a new branch location')

@section('content')
<div class="max-w-2xl">
    <x-card>
        <form action="{{ route('admin.branches.store') }}" method="POST">
            @csrf

            <div class="space-y-4">
                <x-input label="Branch Name" name="branch_name" id="branch_name" :required="true" value="{{ old('branch_name') }}" />
                <x-input label="Branch Code" name="branch_code" id="branch_code" value="{{ old('branch_code') }}" help="Leave empty for auto-generation." />
                <x-input label="Contact Number" name="contact_number" id="contact_number" value="{{ old('contact_number') }}" />
                <x-textarea label="Address" name="address" id="address">{{ old('address') }}</x-textarea>
                <x-checkbox label="Active" name="is_active" id="is_active" :checked="old('is_active', true)" />
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.branches.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Save Branch</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection

