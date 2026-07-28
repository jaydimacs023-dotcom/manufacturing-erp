@extends('layouts.app')

@section('page-header', 'Account & Journal Mappings')
@section('page-description', 'Manage accounting mappings')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-medium text-gray-900">Journal Mappings</h3>
        @can('accounting-event-post')
            <x-button variant="primary" href="{{ route('admin.accounting.mappings.create-journal') }}">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Journal Mapping
            </x-button>
        @endcan
    </div>

    @php
        $journalMappingRows = $journalMappings->map(fn ($mapping) => (object) [
            'cells' => [
                ucwords(str_replace('_', ' ', $mapping->transaction_type)),
                $mapping->debit_account_code
                    ? $mapping->debit_account_code . ' - ' . $mapping->debit_account_name
                    : '-',
                $mapping->credit_account_code
                    ? $mapping->credit_account_code . ' - ' . $mapping->credit_account_name
                    : '-',
                view('components.badge', [
                    'status' => $mapping->is_active ? 'active' : 'inactive',
                ])->with('slot', $mapping->is_active ? 'Active' : 'Inactive'),
                '<a href="' . route('admin.accounting.mappings.edit-journal', $mapping) . '" class="text-blue-600 hover:text-blue-800">Edit</a>',
            ],
        ]);
    @endphp

    <x-table
        :headers="['Transaction Type', 'Debit Account', 'Credit Account', 'Active', 'Actions']"
        :rows="$journalMappingRows"
        empty="No journal mappings found."
    >
    </x-table>

    <div class="mt-8 flex items-center justify-between">
        <h3 class="text-lg font-medium text-gray-900">Account Mappings</h3>
        @can('accounting-event-post')
            <x-button variant="primary" href="{{ route('admin.accounting.mappings.create-account') }}">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                New Account Mapping
            </x-button>
        @endcan
    </div>

    @php
        $accountMappingRows = $accountMappings->map(fn ($mapping) => (object) [
            'cells' => [
                ucfirst($mapping->mapping_type),
                ucfirst($mapping->source_type),
                $mapping->account_code . ' - ' . $mapping->account_name,
                ucfirst($mapping->direction),
                view('components.badge', [
                    'status' => $mapping->is_active ? 'active' : 'inactive',
                ])->with('slot', $mapping->is_active ? 'Active' : 'Inactive'),
                '<a href="' . route('admin.accounting.mappings.edit-account', $mapping) . '" class="text-blue-600 hover:text-blue-800">Edit</a>',
            ],
        ]);
    @endphp

    <x-table
        :headers="['Type', 'Source', 'Account', 'Direction', 'Active', 'Actions']"
        :rows="$accountMappingRows"
        empty="No account mappings found."
    >
    </x-table>
</div>
@endsection
