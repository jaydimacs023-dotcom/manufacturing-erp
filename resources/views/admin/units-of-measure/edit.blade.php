@extends('layouts.app')

@section('page-header', 'Edit Unit of Measure')
@section('page-description', 'Update unit of measure information')

@section('content')
<div class="max-w-2xl">
    <x-card>
        <form action="{{ route('admin.units-of-measure.update', $unitsOfMeasure) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                <x-input label="UOM Code" name="uom_code" id="uom_code" :required="true" value="{{ old('uom_code', $unitsOfMeasure->uom_code) }}" />
                <x-input label="UOM Name" name="uom_name" id="uom_name" :required="true" value="{{ old('uom_name', $unitsOfMeasure->uom_name) }}" />
                <x-select label="UOM Type" name="uom_type" id="uom_type" :required="true" :options="['reference' => 'Reference', 'transactional' => 'Transactional']" :selected="old('uom_type', $unitsOfMeasure->uom_type)" />
                <x-checkbox label="Active" name="is_active" id="is_active" :checked="old('is_active', $unitsOfMeasure->is_active)" />
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.units-of-measure.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Update UOM</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection

