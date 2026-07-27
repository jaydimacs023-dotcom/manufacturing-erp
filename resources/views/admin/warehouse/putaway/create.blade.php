@extends('layouts.app')

@section('page-header', 'Create Put-away')
@section('page-description', 'Assign storage location for incoming materials')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.warehouse.putaway.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="Put-away Number" name="putaway_number" id="putaway_number" value="{{ old('putaway_number') }}" help="Leave empty for auto-generation." />
                <x-select label="Warehouse" name="warehouse_id" id="warehouse_id" :required="true" :options="$warehouses->pluck('warehouse_name', 'id')->toArray()" :selected="old('warehouse_id')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-select label="Storage Location" name="storage_location_id" id="storage_location_id" :required="true" :options="[]" :selected="old('storage_location_id')" />
                <x-select label="Product" name="product_id" id="product_id" :required="true" :options="$products->pluck('product_name', 'id')->toArray()" :selected="old('product_id')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Quantity" name="quantity" id="quantity" type="number" step="0.0001" :required="true" value="{{ old('quantity') }}" />
                <x-input label="Batch Number" name="batch_number" id="batch_number" value="{{ old('batch_number') }}" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Put-away Date" name="putaway_date" id="putaway_date" type="date" :required="true" value="{{ old('putaway_date', date('Y-m-d')) }}" />
                <x-input label="Reference Number" name="reference_number" id="reference_number" value="{{ old('reference_number') }}" help="e.g. GR number" />
            </div>

            <div class="mt-4">
                <x-textarea label="Remarks" name="remarks" id="remarks">{{ old('remarks') }}</x-textarea>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.warehouse.putaway.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Save Put-away</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('warehouse_id')?.addEventListener('change', function() {
    const warehouseId = this.value;
    if (warehouseId) {
        fetch(`/admin/warehouse/locations/${warehouseId}`)
            .then(r => r.json())
            .then(data => {
                const locSelect = document.getElementById('storage_location_id');
                locSelect.innerHTML = '<option value="">Select Location</option>';
                data.forEach(loc => {
                    locSelect.innerHTML += `<option value="${loc.id}">${loc.location_code}${loc.storage_area ? ' - ' + loc.storage_area : ''}</option>`;
                });
            });
    }
});
</script>
@endpush

