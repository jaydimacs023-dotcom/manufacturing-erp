@extends('layouts.app')

@section('page-header', 'Edit Bill of Materials')
@section('page-description', 'Update BOM information')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.manufacturing.bom.update', $billOfMaterial) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="BOM Number" name="bom_number" id="bom_number" :required="true" value="{{ old('bom_number', $billOfMaterial->bom_number) }}" />
                <x-select label="Status" name="status" id="status" :options="['draft' => 'Draft', 'active' => 'Active', 'approved' => 'Approved', 'inactive' => 'Inactive']" :selected="old('status', $billOfMaterial->status)" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-select label="Product" name="product_id" id="product_id" :required="true" :options="$products->pluck('product_name', 'id')->toArray()" :selected="old('product_id', $billOfMaterial->product_id)" />
                <x-input label="UOM ID" name="uom_id" id="uom_id" type="number" :required="true" value="{{ old('uom_id', $billOfMaterial->uom_id) }}" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Version" name="version" id="version" :required="true" value="{{ old('version', $billOfMaterial->version) }}" />
                <x-input label="Effective Date" name="effective_date" id="effective_date" type="date" :required="true" value="{{ old('effective_date', $billOfMaterial->effective_date ? $billOfMaterial->effective_date->format('Y-m-d') : date('Y-m-d')) }}" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Total Quantity" name="total_quantity" id="total_quantity" type="number" step="0.0001" :required="true" value="{{ old('total_quantity', $billOfMaterial->total_quantity) }}" />
            </div>

            <div class="mt-4">
                <x-textarea label="Description" name="description" id="description">{{ old('description', $billOfMaterial->description) }}</x-textarea>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.manufacturing.bom.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Update BOM</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
