@extends('layouts.app')

@section('page-header', 'Edit Payment Term')
@section('page-description', 'Update payment term information')

@section('content')
<div class="max-w-2xl">
    <x-card>
        <form action="{{ route('admin.payment-terms.update', $paymentTerm) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <x-input label="Term Name" name="term_name" id="term_name" :required="true" value="{{ old('term_name', $paymentTerm->term_name) }}" />
                <x-input label="Term Code" name="term_code" id="term_code" value="{{ old('term_code', $paymentTerm->term_code) }}" />
                <x-input label="Due Days" name="due_days" id="due_days" type="number" value="{{ old('due_days', $paymentTerm->due_days) }}" />
                <x-textarea label="Description" name="description" id="description">{{ old('description', $paymentTerm->description) }}</x-textarea>
                <x-checkbox label="Active" name="is_active" id="is_active" :checked="old('is_active', $paymentTerm->is_active)" />
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.payment-terms.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Update Payment Term</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
