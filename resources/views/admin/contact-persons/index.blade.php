@extends('layouts.app')

@section('page-header', 'Contact Persons for ' . $businessPartner->partner_name)
@section('page-description', 'Manage contact persons')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div></div>
        @can('business-partner-update')
            <x-button variant="primary" href="{{ route('admin.business-partners.contact-persons.create', $businessPartner) }}">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Add Contact Person
            </x-button>
        @endcan
    </div>

    <x-table :headers="['Name', 'Position', 'Mobile', 'Email', 'Primary', 'Actions']" :rows="$contactPersons->map(fn($c) => (object)[
        'cells' => [
            $c->name,
            $c->position ?? '-',
            $c->mobile ?? '-',
            $c->email ?? '-',
            $c->is_primary ? 'Yes' : 'No',
            view('admin.contact-persons._actions', ['businessPartner' => $businessPartner, 'contactPerson' => $c])->render(),
        ]
    ])" empty="No contact persons found.">
    </x-table>

    <div class="flex items-center justify-start">
        <x-button variant="secondary" href="{{ route('admin.business-partners.show', $businessPartner) }}">Back to Partner</x-button>
    </div>
@endsection
