@extends('layouts.app')

@section('page-header', 'Create Journal Mapping')
@section('page-description', 'Map a transaction type to debit/credit accounts')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.accounting.mappings.store-journal') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 gap-4">
                <x-select label="Transaction Type" name="transaction_type" id="transaction_type" :required="true" :options="$transactionTypes" :selected="old('transaction_type')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Debit Account Code" name="debit_account_code" id="debit_account_code" value="{{ old('debit_account_code') }}" />
                <x-input label="Debit Account Name" name="debit_account_name" id="debit_account_name" value="{{ old('debit_account_name') }}" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Credit Account Code" name="credit_account_code" id="credit_account_code" value="{{ old('credit_account_code') }}" />
                <x-input label="Credit Account Name" name="credit_account_name" id="credit_account_name" value="{{ old('credit_account_name') }}" />
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
