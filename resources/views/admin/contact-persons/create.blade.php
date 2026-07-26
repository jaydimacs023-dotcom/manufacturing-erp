@extends('layouts.app')

@section('page-header', 'Add Contact Person')
@section('page-description', 'Add a contact person for ' . $businessPartner->partner_name)

@section('content')
<div class="max-w-2xl">
    <x-card>
        <form action="{{ route('admin.business-partners.contact-persons.store', $businessPartner) }}" method="POST">
            @csrf

            <div class="space-y-4">
                <x-input label="Name" name="name" id="name" :required="true" value="{{ old('name') }}" placeholder="Contact person name" />
                <x-input label="Position" name="position" id="position" value="{{ old('position') }}" placeholder="e.g., Procurement Manager" />
                <x-input label="Mobile" name="mobile" id="mobile" value="{{ old('mobile') }}" placeholder="e.g., +63 912 345 6789" />
                <x-input label="Email" name="email" id="email" type="email" value="{{ old('email') }}" />
                <x-checkbox label="Primary Contact" name="is_primary" id="is_primary" :checked="old('is_primary', false)" />
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.business-partners.show', $businessPartner) }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Add Contact Person</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
