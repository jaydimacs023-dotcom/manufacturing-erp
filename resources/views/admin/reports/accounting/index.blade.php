@extends('layouts.app')

@section('page-header', 'Accounting Reports')
@section('page-description', 'Accounting events and posting status')

@section('content')
<div class="space-y-6">
    @include('admin.reports._filters', ['route' => route('admin.reports.accounting')])

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <x-stat-card label="Total Events" :value="$total_events" icon="file-text" color="blue" />
        <x-stat-card label="Pending" :value="$pending_events" icon="clock" color="yellow" />
        <x-stat-card label="Posted" :value="$posted_events" icon="check-circle" color="green" />
        <x-stat-card label="Failed" :value="$failed_events" icon="x-circle" color="red" />
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <x-stat-card label="Queue Pending" :value="$queue_pending" icon="clock" color="yellow" />
        <x-stat-card label="Queue Failed" :value="$queue_failed" icon="alert-triangle" color="red" />
    </div>

    <x-card title="Recent Accounting Events" description="Latest events">
