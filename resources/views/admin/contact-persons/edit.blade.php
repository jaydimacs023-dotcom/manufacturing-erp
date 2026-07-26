@extends('layouts.app')

@section('page-header', 'Edit Contact Person')
@section('page-description', 'Update contact person information')

@section('content')
<div class="max-w-2xl">
    <x-card>
        <form action="{{ route('admin.business-partners.contact-persons.update', [$businessPartner, $contactPerson]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <x-input label="Name" name="name" id="name" :required="true" value="{{ old('name', $contactPerson->name) }}" />
                <x-input label="Position" name="position" id="position" value="{{ old('position', $contactPerson->position) }}" />
                <x-input label="Mobile" name="mobile" id="mobile" value="{{ old('mobile', $contactPerson->mobile) }}" />
                <x-input label="Email" name="email" id="email" type="email" value="{{ old('email', $contactPerson->email) }}" />
                <x-checkbox label="Primary Contact" name="is_primary" id="is_primary" :checked="old('is_primary', $contactPerson->is_primary)" />
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.business-partners.show', $businessPartner) }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Update Contact Person</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
