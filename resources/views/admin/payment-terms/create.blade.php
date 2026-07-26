@extends('layouts.app')

@section('page-header', 'Create Payment Term')
@section('page-description', 'Add a new payment term')

@section('content')
<div class="max-w-2xl">
    <x-card>
        <form action="{{ route('admin.payment-terms.store') }}" method="POST">
            @csrf

            <div class="space-y-4">
                <x-input label="Term Name" name="term_name" id="term_name" :required="true" value="{{ old('term_name') }}" placeholder="e.g., Net 30 Days" />
                <x-input label="Term Code" name="term_code" id="term_code" value="{{ old('term_code') }}" help="Leave empty for auto-generation." />
                <x-input label="Due Days" name="due_days" id="due_days" type="number" value="{{ old('due_days', 0) }}" help="Number of days until payment is due. 0 for immediate payment." />
                <x-textarea label="Description" name="description" id="description">{{ old('description') }}</x-textarea>
                <x-checkbox label="Active" name="is_active" id="is_active" :checked="old('is_active', true)" />
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.payment-terms.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Save Payment Term</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
