@extends('layouts.app')

@section('page-header', 'Production Dashboard')
@section('page-description', 'Track material issues, outputs, and waste')

@section('content')
<div class="space-y-6">
    <!-- Quick Actions -->
    <div class="flex items-center space-x-3">
        @can('manufacturing-order-start')
            <x-button variant="primary" href="{{ route('admin.manufacturing.production.issue') }}">
                Issue Materials
            </x-button>
        @endcan
        @can('manufacturing-order-complete')
            <x-button variant="success" href="{{ route('admin.manufacturing.production.output') }}">
                Record Output
            </x-button>
        @endcan
        @can('manufacturing-order-start')
            <x-button variant="secondary" href="{{ route('admin.manufacturing.production.waste') }}">
                Record Waste
            </x-button>
        @endcan
    </div>

    <!-- Material Issues -->
    <x-card title="Material Issues" description="Recent material issues">
        @if($materialIssues->count() > 0)
            <x-table :headers="['Issue #', 'MO #', 'Warehouse', 'Date', 'Status']" :rows="$materialIssues->take(5)->map(fn($issue) => (object)[
                'cells' => [
                    $issue->issue_number,
                    $issue->manufacturingOrder->mo_number ?? '-',
                    $issue->warehouse->warehouse_name ?? '-',
                    $issue->issue_date ? $issue->issue_date->format('Y-m-d') : '-',
                    view('components.badge', ['status' => $issue->status === 'completed' ? 'active' : ($issue->status === 'cancelled' ? 'inactive' : 'info')])->with('slot', ucfirst($issue->status)),
                ]
            ])" empty="No material issues yet.">
            </x-table>
        @else
            <p class="text-gray-500 text-sm py-4 text-center">No material issues recorded yet.</p>
        @endif
    </x-card>

    <!-- Production Outputs -->
    <x-card title="Production Outputs" description="Finished goods output">
        @if($outputs->count() > 0)
            <x-table :headers="['Output #', 'MO #', 'Product', 'Produced', 'Yield %', 'Status']" :rows="$outputs->take(5)->map(fn($output) => (object)[
                'cells' => [
                    $output->output_number,
                    $output->manufacturingOrder->mo_number ?? '-',
                    $output->product->product_name ?? '-',
                    number_format($output->quantity_produced, 0),
                    $output->yield_percentage ? number_format($output->yield_percentage, 2) . '%' : '-',
                    view('components.badge', ['status' => $output->status === 'approved' ? 'active' : ($output->status === 'rejected' ? 'inactive' : 'warning')])->with('slot', ucwords(str_replace('_', ' ', $output->status))),
                ]
            ])" empty="No outputs yet.">
            </x-table>
        @else
            <p class="text-gray-500 text-sm py-4 text-center">No production outputs recorded yet.</p>
        @endif
    </x-card>

    <!-- Waste Records -->
    <x-card title="Waste Records" description="Production waste tracking">
        @if($wastes->count() > 0)
            <x-table :headers="['Waste #', 'MO #', 'Type', 'Quantity', 'Reason']" :rows="$wastes->take(5)->map(fn($waste) => (object)[
                'cells' => [
                    $waste->waste_number,
                    $waste->manufacturingOrder->mo_number ?? '-',
                    ucwords(str_replace('_', ' ', $waste->waste_type)),
                    number_format($waste->quantity, 4),
                    $waste->reason,
                ]
            ])" empty="No waste records yet.">
            </x-table>
        @else
            <p class="text-gray-500 text-sm py-4 text-center">No waste records recorded yet.</p>
        @endif
    </x-card>
</div>
@endsection
