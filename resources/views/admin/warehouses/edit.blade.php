@extends('layouts.app')

@section('page-header', 'Edit Warehouse')
@section('page-description', 'Update warehouse information')

@section('content')
<div class="max-w-2xl mx-auto">
    <x-card>
        <form action="{{ route('admin.warehouses.update', $warehouse) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-4">
