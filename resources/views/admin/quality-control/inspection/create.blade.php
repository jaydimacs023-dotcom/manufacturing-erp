@extends('layouts.app')

@section('page-header', 'Create Quality Inspection')
@section('page-description', 'Record a new quality inspection')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.quality-control.inspections.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="Inspection Number" name="inspection_number" id="inspection_number" value="{{ old('inspection_number') }}" help="Leave empty for auto-generation." />
                <x-select label="Inspection Type" name="inspection_type" id="inspection_type" :required="true" :options="$inspectionTypes" :selected="old('inspection_type')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-select label="Product" name="product_id" id="product_id" :required="true" :options="$products->pluck('product_name', 'id')->toArray()" :selected="old('product_id')" />
                <x-select label="Checklist" name="quality_checklist_id" id="quality_checklist_id" :options="$checklists->pluck('name', 'id')->toArray()" :selected="old('quality_checklist_id')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Batch Number" name="batch_number" id="batch_number" value="{{ old('batch_number') }}" />
                <x-input label="Lot Number" name="lot_number" id="lot_number" value="{{ old('lot_number') }}" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Inspection Date" name="inspection_date" id="inspection_date" type="date" :required="true" value="{{ old('inspection_date', date('Y-m-d')) }}" />
                <x-input label="Inspector" name="inspector_id" id="inspector_id" type="number" help="User ID of the inspector" value="{{ old('inspector_id', auth()->id()) }}" />
            </div>

            <div class="mt-4">
                <x-textarea label="Remarks" name="remarks" id="remarks">{{ old('remarks') }}</x-textarea>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.quality-control.inspections.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Save Inspection</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection

