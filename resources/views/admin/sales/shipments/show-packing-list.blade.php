@extends('layouts.app')

@section('page-header', $packingList->packing_list_number)
@section('page-description', 'Packing list details')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card title="Packing List Information" description="Document details">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Packing List Number</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $packingList->packing_list_number }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Export Order</dt>
                    <dd class="text-sm text-gray-700">
