@extends('layouts.app')

@section('page-header', 'Create Business Partner')
@section('page-description', 'Add a new supplier, customer, or service provider')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.business-partners.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="Partner Name" name="partner_name" id="partner_name" :required="true" value="{{ old('partner_name') }}" />
                <x-input label="Partner Code" name="partner_code" id="partner_code" value="{{ old('partner_code') }}" help="Leave empty for auto-generation." />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-select label="Partner Type" name="partner_type" id="partner_type" :required="true" :options="$partnerTypes" :selected="old('partner_type')" />
                <x-select label="Payment Term" name="payment_term_id" id="payment_term_id" :options="$paymentTerms->pluck('term_name', 'id')->toArray()" :selected="old('payment_term_id')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Tax Identification Number" name="tax_identification_number" id="tax_identification_number" value="{{ old('tax_identification_number') }}" />
                <x-input label="Country" name="country" id="country" value="{{ old('country') }}" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Phone" name="phone" id="phone" value="{{ old('phone') }}" />
                <x-input label="Email" name="email" id="email" type="email" value="{{ old('email') }}" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Website" name="website" id="website" value="{{ old('website') }}" />
                <x-input label="Credit Limit" name="credit_limit" id="credit_limit" type="number" step="0.01" value="{{ old('credit_limit') }}" help="Applicable for customers." />
            </div>

            <div class="mt-4">
                <x-textarea label="Address" name="address" id="address">{{ old('address') }}</x-textarea>
            </div>

            <div class="mt-4">
                <x-checkbox label="Active" name="is_active" id="is_active" :checked="old('is_active', true)" />
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.business-partners.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Save Business Partner</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
