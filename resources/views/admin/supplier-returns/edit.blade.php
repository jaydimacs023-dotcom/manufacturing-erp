@extends('layouts.app')

@section('page-header', 'Edit Supplier Return')
@section('page-description', 'Update supplier return information')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.supplier-returns.update', $supplierReturn) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="Return Number" name="supplier_return_number" id="supplier_return_number" :required="true" value="{{ old('supplier_return_number', $supplierReturn->supplier_return_number) }}" />
                <x-select label="Goods Receipt" name="goods_receipt_id" id="goods_receipt_id" :required="true" :options="$goodsReceipts->mapWithKeys(fn($gr) => [$gr->id => $gr->goods_receipt_number . ' - ' . ($gr->purchaseOrder->supplier->partner_name ?? '')])->toArray()" :selected="old('goods_receipt_id', $supplierReturn->goods_receipt_id)" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Return Date" name="return_date" id="return_date" type="date" :required="true" value="{{ old('return_date', $supplierReturn->return_date->format('Y-m-d')) }}" />
                <x-select label="Warehouse" name="warehouse_id" id="warehouse_id" :required="true" :options="$warehouses->pluck('warehouse_name', 'id')->toArray()" :selected="old('warehouse_id', $supplierReturn->warehouse_id)" />
            </div>

            <div class="mt-4">
                <x-select label="Reason" name="reason" id="reason" :required="true" :options="$reasons" :selected="old('reason', $supplierReturn->reason)" />
            </div>

            <div class="mt-4">
                <x-textarea label="Remarks" name="remarks" id="remarks">{{ old('remarks', $supplierReturn->remarks) }}</x-textarea>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.supplier-returns.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Update Supplier Return</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
