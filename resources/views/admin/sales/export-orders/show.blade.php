@extends('layouts.app')

@section('page-header', $exportOrder->export_order_number)
@section('page-description', 'Export order details')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card title="Export Order Information" description="Basic details">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Export Order Number</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $exportOrder->export_order_number }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Status</dt>
                    <dd>
                        <x-badge :status="$exportOrder->status === 'delivered' ? 'active' : ($exportOrder->status === 'cancelled' ? 'inactive' : ($exportOrder->status === 'planned' ? 'info' : 'in-progress'))">
                            {{ ucfirst(str_replace('_', ' ', $exportOrder->status)) }}
                        </x-badge>
                    </dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Customer</dt>
                    <dd class="text-sm text-gray-700">{{ $exportOrder->customer->partner_name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Destination Country</dt>
                    <dd class="text-sm text-gray-700">{{ $exportOrder->destination_country }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Shipping Details">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Port of Loading</dt>
                    <dd class="text-sm text-gray-700">{{ $exportOrder->port_of_loading ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Port of Destination</dt>

