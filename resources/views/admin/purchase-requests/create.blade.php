@extends('layouts.app')

@section('page-header', 'Create Purchase Request')
@section('page-description', 'Submit a new purchase request for materials or services')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.purchase-requests.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-input label="Request Number" name="request_number" id="request_number" value="{{ old('request_number') }}" help="Leave empty for auto-generation." />
                <x-input label="Request Date" name="request_date" id="request_date" type="date" :required="true" value="{{ old('request_date', date('Y-m-d')) }}" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-select label="Department" name="department_id" id="department_id" :required="true" :options="$departments->pluck('department_name', 'id')->toArray()" :selected="old('department_id')" />
                <x-select label="Priority" name="priority" id="priority" :required="true" :options="$priorities" :selected="old('priority', 'normal')" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                <x-input label="Required Date" name="required_date" id="required_date" type="date" value="{{ old('required_date') }}" />
                <x-input label="Requested By" name="requested_by" id="requested_by" :required="true" value="{{ old('requested_by', auth()->user()->name ?? '') }}" />
            </div>

            <div class="mt-4">
                <x-textarea label="Remarks" name="remarks" id="remarks">{{ old('remarks') }}</x-textarea>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <x-button variant="secondary" href="{{ route('admin.purchase-requests.index') }}">Cancel</x-button>
                <x-button variant="primary" type="submit">Save Purchase Request</x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection
