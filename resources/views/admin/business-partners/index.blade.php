@extends('layouts.app')

@section('page-header', 'Business Partners')
@section('page-description', 'Manage suppliers, customers, and other business partners')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <input type="text" placeholder="Search partners..." class="rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 w-64">
        </div>
        @can('business-partner-create')
            <x-button variant="primary" href="{{ route('admin.business-partners.create') }}">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Business Partner
            </x-button>
        @endcan
    </div>

    <x-table :headers="['Code', 'Name', 'Type', 'Contact', 'Payment Term', 'Status', 'Actions']" :rows="$businessPartners->map(fn($p) => (object)[
        'cells' => [
            $p->partner_code,
            $p->partner_name,
            ucwords(str_replace('_', ' ', $p->partner_type)),
            $p->email ?? $p->phone ?? '-',
            $p->paymentTerm->term_name ?? '-',
            view('components.badge', ['status' => $p->is_active ? 'active' : 'inactive'])->with('slot', $p->is_active ? 'Active' : 'Inactive'),
            view('admin.business-partners._actions', ['businessPartner' => $p])->render(),
        ]
    ])" empty="No business partners found." actionLabel="New Business Partner" actionRoute="{{ route('admin.business-partners.create') }}">
    </x-table>

    <div class="mt-4">
        {{ $businessPartners->links() }}
    </div>
@endsection
