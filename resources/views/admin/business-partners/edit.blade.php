@extends('layouts.app')

@section('page-header', 'Edit Business Partner')
@section('page-description', 'Update business partner information')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.business-partners.update', $businessPartner) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="Partner Name" name="partner_name" id="partner_name" :required="true" value="{{ old('partner_name', $businessPartner->partner_name) }}" />
                <x-input label="Partner Code" name="partner_code" id="partner_code" value="{{ old('partner_code', $businessPartner->partner_code) }}" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-select label="Partner Type" name="partner_type" id="partner_type" :required="true" :options="$partnerTypes" :selected="old('partner_type', $businessPartner->partner_type)" />
                <x-select label="Payment Term" name="payment_term_id" id="payment_term_id" :options="$paymentTerms->pluck('term_name', 'id')->toArray()" :selected="old('payment_term_id', $businessPartner->payment_term_id)" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Tax Identification Number" name="tax_identification_number" id="tax_identification_number" value="{{ old('tax_identification_number', $businessPartner->tax_identification_number) }}" />
                <x-input label="Country" name="country" id="country" value="{{ old('country', $businessPartner->country) }}" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Phone" name="phone" id="phone" value="{{ old('phone', $businessPartner->phone) }}" />
                <x-input label="Email" name="email" id="email" type="email" value="{{ old('email', $businessPartner->email) }}" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Website" name="website" id="website" value="{{ old('website', $businessPartner->website) }}" />
                <x-input label="Credit Limit" name="credit_limit" id="credit_limit" type="number" step="0.01" value="{{ old('credit_limit', $businessPartner->credit_limit) }}" />
            </div>

            <div class="mt-4">
                <x-textarea label="Address" name="address" id="address">{{ old('address', $businessPartner->address) }}</x-textarea>
            </div>

            <div class="mt-4">
                <x-checkbox label="Active" name="is_active" id="is_active" :checked="old('is_active', $businessPartner->is_active)" />
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.business-partners.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Update Business Partner</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
