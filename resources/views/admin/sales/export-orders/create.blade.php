@extends('layouts.app')

@section('page-header', 'Create Export Order')
@section('page-description', 'Create a new export shipment order')

@section('content')
<div class="max-w-4xl">
    <x-card>
        <form action="{{ route('admin.sales.export-orders.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="Export Order Number" name="export_order_number" id="export_order_number" value="{{ old('export_order_number') }}" help="Leave empty for auto-generation." />
                <x-select label="Customer" name="customer_id" id="customer_id" :required="true" :options="$customers->pluck('partner_name', 'id')->toArray()" :selected="old('customer_id')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Destination Country" name="destination_country" id="destination_country" :required="true" value="{{ old('destination_country') }}" />
                <x-input label="Port of Loading" name="port_of_loading" id="port_of_loading" value="{{ old('port_of_loading') }}" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Port of Destination" name="port_of_destination" id="port_of_destination" value="{{ old('port_of_destination') }}" />
                <x-input label="Vessel" name="vessel" id="vessel" value="{{ old('vessel') }}" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="ETD (Estimated Departure)" name="etd" id="etd" type="date" value="{{ old('etd') }}" />
                <x-input label="ETA (Estimated Arrival)" name="eta" id="eta" type="date" value="{{ old('eta') }}" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Container Number" name="container_number" id="container_number" value="{{ old('container_number') }}" />
                <x-input label="Seal Number" name="seal_number" id="seal_number" value="{{ old('seal_number') }}" />
            </div>

            <div class="mt-4">
                <x-textarea label="Notes" name="notes" id="notes">{{ old('notes') }}</x-textarea>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.sales.export-orders.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Save Export Order</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection

