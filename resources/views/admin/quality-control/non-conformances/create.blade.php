@extends('layouts.app')

@section('page-header', 'Record Non-Conformance')
@section('page-description', 'Document a quality defect')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.quality-control.non-conformances.store') }}" method="POST">
            @csrf

            <input type="hidden" name="quality_inspection_id" value="{{ request('quality_inspection_id', old('quality_inspection_id')) }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="Quality Inspection ID" name="quality_inspection_id_display" id="quality_inspection_id_display" :value="request('quality_inspection_id', old('quality_inspection_id'))" help="Enter inspection ID or pass via URL parameter" />
                <x-select label="Defect Type" name="defect_type_id" id="defect_type_id" :options="$defectTypes->pluck('name', 'id')->toArray()" :selected="old('defect_type_id')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Defect Type Name" name="defect_type" id="defect_type" :required="true" value="{{ old('defect_type') }}" help="If no defect type selected" />
                <x-select label="Severity" name="severity" id="severity" :required="true" :options="$severities" :selected="old('severity', 'minor')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Quantity Affected" name="quantity_affected" id="quantity_affected" type="number" step="0.0001" :required="true" value="{{ old('quantity_affected', 0) }}" />
                <x-input label="Responsible Department" name="responsible_department" id="responsible_department" value="{{ old('responsible_department') }}" />
            </div>

            <div class="mt-4">
                <x-textarea label="Description" name="description" id="description" :required="true">{{ old('description') }}</x-textarea>
            </div>

            <div class="mt-4">
                <x-textarea label="Root Cause" name="root_cause" id="root_cause">{{ old('root_cause') }}</x-textarea>
            </div>

            <div class="mt-4">
                <x-textarea label="Recommended Action" name="recommended_action" id="recommended_action">{{ old('recommended_action') }}</x-textarea>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.quality-control.non-conformances.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Record Non-Conformance</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection

