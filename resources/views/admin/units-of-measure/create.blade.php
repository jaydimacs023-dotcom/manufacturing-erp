@extends('layouts.app')

@section('page-header', 'Create Unit of Measure')
@section('page-description', 'Add a new unit of measure')

@section('content')
<div class="max-w-2xl">
    <x-card>
        <form action="{{ route('admin.units-of-measure.store') }}" method="POST">
            @csrf

            <div class="space-y-4">
                <x-input label="UOM Code" name="uom_code" id="uom_code" :required="true" value="{{ old('uom_code') }}" />
                <x-input label="UOM Name" name="uom_name" id="uom_name" :required="true" value="{{ old('uom_name') }}" />
                <x-select label="UOM Type" name="uom_type" id="uom_type" :required="true" :options="['reference' => 'Reference', 'transactional' => 'Transactional']" :selected="old('uom_type', 'reference')" />
                <x-checkbox label="Active" name="is_active" id="is_active" :checked="old('is_active', true)" />
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.units-of-measure.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Save UOM</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection

