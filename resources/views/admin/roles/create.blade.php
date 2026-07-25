@extends('layouts.app')

@section('page-header', 'Create Role')
@section('page-description', 'Define a new role with permissions')

@section('content')
<div class="max-w-3xl">
    <x-card>
        <form action="{{ route('admin.roles.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <x-input
                    label="Role Name"
                    name="name"
                    id="name"
                    :value="old('name')"
                    required
                    placeholder="e.g., Purchasing Officer, Production Supervisor"
                />
            </div>

            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Permissions</h3>

                @foreach($permissions as $group =>
