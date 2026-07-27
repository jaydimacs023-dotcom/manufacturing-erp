@extends('layouts.app')

@section('page-header', 'Create Corrective Action')
@section('page-description', 'Define a corrective action for a quality issue')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.quality-control.corrective-actions.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="Quality Inspection ID" name="quality_inspection_id" id="quality_inspection_id" type="number" :required="true" value="{{ old('quality_inspection_id', request('quality_inspection_id')) }}" />
                <x-input label="Non-Conformance ID" name="non_conformance_id" id="non_conformance_id" type="number" value="{{ old('non_conformance_id', request('non_conformance_id')) }}" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-select label="Action Type" name="action_type" id="action_type" :required="true" :options="$actionTypes" :selected="old('action_type')" />
                <x-input label="Due Date" name="due_date" id="due_date" type="date" value="{{ old('due_date') }}" />
            </div>

            <div class="mt-4">
                <x-input label="Responsible Person ID" name="responsible_person_id" id="responsible_person_id" type="number" value="{{ old('responsible_person_id') }}" />
            </div>

            <div class="mt-4">
                <x-textarea label="Description" name="description" id="description" :required="true">{{ old('description') }}</x-textarea>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.quality-control.corrective-actions.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Create Action</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection

