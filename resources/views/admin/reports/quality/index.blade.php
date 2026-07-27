@extends('layouts.app')

@section('page-header', 'Quality Control Reports')
@section('page-description', 'Inspection and quality analysis')

@section('content')
<div class="space-y-6">
    @include('admin.reports._filters', ['route' => route('admin.reports.quality')])

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <x-stat-card label="Total Inspections" :value="$total_inspections" icon="clipboard-check" color="blue" />
        <x-stat-card label="Passed" :value="$passed" icon="check-circle" color="green" />
        <x-stat-card label="Failed" :value="$failed" icon="x-circle" color="red" />
        <x-stat-card label="Pass Rate" :value="$pass_rate . '%'" icon="check-circle" color="green" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
        <x-stat-card label="Open Non-Conformances" :value="$open_non_conformances" icon="alert-triangle" color="yellow" />
    </div>

    <x-card title="Recent Inspections" description="Latest quality inspections">
        <x-table :headers="['Product', 'Inspector', 'Status', 'Date']" :rows="collect($inspections)->map(fn($i) => (object)[
            'cells' => [$i->product?->product_name ?? '-', $i->inspector?->name ?? '-', ucfirst($i->status), $i->created_at->format('Y-m-d')]
        ])" empty="No inspections found." />
    </x-card>
</div>
@endsection

