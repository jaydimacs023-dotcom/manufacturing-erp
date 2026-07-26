@extends('layouts.app')

@section('page-header', $businessPartner->partner_name)
@section('page-description', 'Business partner details and contact persons')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card title="Partner Information" description="Basic partner details">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Partner Code</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $businessPartner->partner_code }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Partner Name</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $businessPartner->partner_name }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Type</dt>
                    <dd class="text-sm text-gray-700">{{ ucwords(str_replace('_', ' ', $businessPartner->partner_type)) }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Status</dt>
                    <dd>
                        <x-badge :status="$businessPartner->is_active ? 'active' : 'inactive'">
                            {{ $businessPartner->is_active ? 'Active' : 'Inactive' }}
                        </x-badge>
                    </dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Contact Information" description="Phone, email, and address">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Phone</dt>
                    <dd class="text-sm text-gray-700">{{ $businessPartner->phone ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Email</dt>
                    <dd class="text-sm text-gray-700">{{ $businessPartner->email ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Website</dt>
                    <dd class="text-sm text-gray-700">{{ $businessPartner->website ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Address</dt>
                    <dd class="text-sm text-gray-700">{{ $businessPartner->address ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Financial Information" description="Payment terms and limits">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Payment Term</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $businessPartner->paymentTerm->term_name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Credit Limit</dt>
                    <dd class="text-sm text-gray-700">{{ $businessPartner->credit_limit ? number_format($businessPartner->credit_limit, 2) : 'N/A' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Tax ID</dt>
                    <dd class="text-sm text-gray-700">{{ $businessPartner->tax_identification_number ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Country</dt>
                    <dd class="text-sm text-gray-700">{{ $businessPartner->country ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>
    </div>

    <x-card title="Contact Persons" description="People associated with this partner">
        <div class="flex items-center justify-between mb-4">
            <div></div>
            @can('business-partner-update')
                <x-button variant="primary" size="sm" href="{{ route('admin.business-partners.contact-persons.create', $businessPartner) }}">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Add Contact Person
                </x-button>
            @endcan
        </div>

        @if($businessPartner->contactPersons->count() > 0)
            <x-table :headers="['Name', 'Position', 'Mobile', 'Email', 'Primary', 'Actions']" :rows="$businessPartner->contactPersons->map(fn($c) => (object)[
                'cells' => [
                    $c->name,
                    $c->position ?? '-',
                    $c->mobile ?? '-',
                    $c->email ?? '-',
                    $c->is_primary ? 'Yes' : 'No',
                    view('admin.contact-persons._actions', ['businessPartner' => $businessPartner, 'contactPerson' => $c])->render(),
                ]
            ])" empty="No contact persons yet.">
            </x-table>
        @else
            <p class="text-gray-500 text-sm py-4 text-center">No contact persons added yet.</p>
        @endif
    </x-card>

    <div class="flex items-center justify-end space-x-3">
        <x-button variant="secondary" href="{{ route('admin.business-partners.index') }}">Back to Partners</x-button>
        @can('business-partner-update')
            <x-button variant="primary" href="{{ route('admin.business-partners.edit', $businessPartner) }}">Edit Partner</x-button>
        @endcan
    </div>
@endsection
