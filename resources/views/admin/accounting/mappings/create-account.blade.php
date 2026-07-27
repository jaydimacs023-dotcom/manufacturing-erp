@extends('layouts.app')

@section('page-header', 'Create Account Mapping')
@section('page-description', 'Map a source type to an account')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.accounting.mappings.store-account') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-select label="Mapping Type" name="mapping_type" id="mapping_type" :required="true" :options="$mappingTypes" :selected="old('mapping_type')" />
                <x-select label="Direction" name="direction" id="direction" :required="true" :options="$directions" :selected="old('direction')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Account Code" name="account_code" id="account_code" :required="true" value="{{ old('account_code') }}" />
                <x-input label="Account Name" name="account_name" id="account_name" :required="true" value="{{ old('account_name') }}" />
            </div>

            <div class="mt-4">
                <x-input label="Source Type" name="source_type" id="source_type" :required="true" value="{{ old('source_type') }}" help="e.g. goods_receipt, shipment, sales_invoice" />
            </div>

            <div class="mt-4">
                <x-textarea label="Description" name="description" id="description">{{ old('description') }}</x-textarea>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.accounting.mappings.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Save Mapping</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
