@extends('layouts.app')

@section('page-header', 'Edit Account Mapping')
@section('page-description', 'Update account mapping configuration')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.accounting.mappings.update-account', $accountMapping) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-select label="Mapping Type" name="mapping_type" id="mapping_type" :required="true" :options="$mappingTypes" :selected="old('mapping_type', $accountMapping->mapping_type)" />
                <x-select label="Direction" name="direction" id="direction" :required="true" :options="$directions" :selected="old('direction', $accountMapping->direction)" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Account Code" name="account_code" id="account_code" :required="true" value="{{ old('account_code', $accountMapping->account_code) }}" />
                <x-input label="Account Name" name="account_name" id="account_name" :required="true" value="{{ old('account_name', $accountMapping->account_name) }}" />
            </div>

            <div class="mt-4">
                <x-input label="Source Type" name="source_type" id="source_type" :required="true" value="{{ old('source_type', $accountMapping->source_type) }}" />
            </div>

            <div class="mt-4">
                <x-textarea label="Description" name="description" id="description">{{ old('description', $accountMapping->description) }}</x-textarea>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.accounting.mappings.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Update Mapping</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
