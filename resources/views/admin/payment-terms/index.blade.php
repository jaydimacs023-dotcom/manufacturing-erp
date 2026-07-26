@extends('layouts.app')

@section('page-header', 'Payment Terms')
@section('page-description', 'Manage payment terms')

@section('content')
<div class="space-y-4">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-2">
            <input type="text" placeholder="Search payment terms..." class="rounded-lg border border-gray-300 px-4 py-2 text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 w-64">
        </div>
        @can('business-partner-create')
            <x-button variant="primary" href="{{ route('admin.payment-terms.create') }}">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Payment Term
            </x-button>
        @endcan
    </div>

    <x-table :headers="['Code', 'Name', 'Due Days', 'Status', 'Created At', 'Actions']" :rows="$paymentTerms->map(fn($t) => (object)[
        'cells' => [
            $t->term_code,
            $t->term_name,
            $t->due_days > 0 ? $t->due_days . ' days' : 'Due on receipt',
            view('components.badge', ['status' => $t->is_active ? 'active' : 'inactive'])->with('slot', $t->is_active ? 'Active' : 'Inactive'),
            $t->created_at->format('Y-m-d'),
            view('admin.payment-terms._actions', ['paymentTerm' => $t])->render(),
        ]
    ])" empty="No payment terms found." actionLabel="New Payment Term" actionRoute="{{ route('admin.payment-terms.create') }}">
    </x-table>

    <div class="mt-4">
        {{ $paymentTerms->links() }}
    </div>
@endsection
