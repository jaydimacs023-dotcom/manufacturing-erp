@extends('layouts.app')

@section('page-header', 'Create Supplier Return')
@section('page-description', 'Record returned goods to supplier')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.supplier-returns.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="Return Number" name="supplier_return_number" id="supplier_return_number" value="{{ old('supplier_return_number') }}" help="Leave empty for auto-generation." />
                <x-select label="Goods Receipt" name="goods_receipt_id" id="goods_receipt_id" :required="true" :options="$goodsReceipts->mapWithKeys(fn($gr) => [$gr->id => $gr->goods_receipt_number . ' - ' . ($gr->purchaseOrder->supplier->partner_name ?? '')])->toArray()" :selected="old('goods_receipt_id')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Return Date" name="return_date" id="return_date" type="date" :required="true" value="{{ old('return_date', date('Y-m-d')) }}" />
                <x-select label="Warehouse" name="warehouse_id" id="warehouse_id" :required="true" :options="$warehouses->pluck('warehouse_name', 'id')->toArray()" :selected="old('warehouse_id')" />
            </div>

            <div class="mt-4">
                <x-select label="Reason" name="reason" id="reason" :required="true" :options="$reasons" :selected="old('reason')" />
            </div>

            <div class="mt-4">
                <x-textarea label="Remarks" name="remarks" id="remarks">{{ old('remarks') }}</x-textarea>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.supplier-returns.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Save Supplier Return</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
