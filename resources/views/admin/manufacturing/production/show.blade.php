@extends('layouts.app')

@section('page-header', 'Production: ' . $mo->mo_number)
@section('page-description', 'Production tracking details')

@section('content')
<div class="space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <x-card title="Order Info" description="Production order">
            <dl class="space-y-3">
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">MO Number</dt>
                    <dd class="text-sm font-medium text-gray-900">{{ $mo->mo_number }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Product</dt>
                    <dd class="text-sm text-gray-700">{{ $mo->product->product_name ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Planned Quantity</dt>
                    <dd class="text-sm text-gray-700">{{ number_format($mo->planned_quantity, 0) }} {{ $mo->uom->uom_code ?? '' }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-medium text-gray-500 uppercase">Warehouse</dt>
                    <dd class="text-sm text-gray-700">{{ $mo->warehouse->warehouse_name ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>

        <x-card title="Material Issues" description="Issued materials">
            @if($issues->count() > 0)
                <x-table :headers="['Issue #', 'Date', 'Items']" :rows="$issues->map(fn($issue) => (object)[
                    'cells' => [
                        $issue->issue_number,
                        $issue->issue_date ? $issue->issue_date->format('Y-m-d') : '-',
                        $issue->items->count(),
                    ]
                ])" empty="No issues.">
                </x-table>
            @else
                <p class="text-gray-500 text-sm py-4 text-center">No materials issued yet.</p>
            @endif
        </x-card>

        <x-card title="Production Output" description="Finished goods">
            @if($outputs->count() > 0)
                <x-table :headers="['Output #', 'Produced', 'Yield %', 'Status']" :rows="$outputs->map(fn($output) => (object)[
                    'cells' => [
                        $output->output_number,
                        number_format($output->quantity_produced, 0),
                        $output->yield_percentage ? number_format($output->yield_percentage, 2) . '%' : '-',
                        view('components.badge', ['status' => $output->status === 'approved' ? 'active' : ($output->status === 'rejected' ? 'inactive' : 'warning')])->with('slot', ucwords(str_replace('_', ' ', $output->status))),
                    ]
                ])" empty="No outputs.">
                </x-table>
            @else
                <p class="text-gray-500 text-sm py-4 text-center">No outputs recorded yet.</p>
            @endif
        </x-card>
    </div>

    <div class="flex items-center justify-between">
        <x-button variant="secondary" href="{{ route('admin.manufacturing.production.index') }}">Back to Dashboard</x-button>
    </div>
</div>
@endsection
