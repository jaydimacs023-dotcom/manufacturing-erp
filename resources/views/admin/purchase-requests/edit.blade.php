@extends('layouts.app')

@section('page-header', 'Edit Purchase Request')
@section('page-description', 'Update purchase request information')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.purchase-requests.update', $purchaseRequest) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="Request Number" name="request_number" id="request_number" :required="true" value="{{ old('request_number', $purchaseRequest->request_number) }}" />
                <x-input label="Request Date" name="request_date" id="request_date" type="date" :required="true" value="{{ old('request_date', $purchaseRequest->request_date->format('Y-m-d')) }}" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-select label="Department" name="department_id" id="department_id" :required="true" :options="$departments->pluck('department_name', 'id')->toArray()" :selected="old('department_id', $purchaseRequest->department_id)" />
                <x-select label="Priority" name="priority" id="priority" :required="true" :options="$priorities" :selected="old('priority', $purchaseRequest->priority)" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Required Date" name="required_date" id="required_date" type="date" value="{{ old('required_date', $purchaseRequest->required_date?->format('Y-m-d')) }}" />
                <x-input label="Requested By" name="requested_by" id="requested_by" :required="true" value="{{ old('requested_by', $purchaseRequest->requested_by) }}" />
            </div>

            <div class="mt-4">
                <x-textarea label="Remarks" name="remarks" id="remarks">{{ old('remarks', $purchaseRequest->remarks) }}</x-textarea>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.purchase-requests.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Update Purchase Request</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
