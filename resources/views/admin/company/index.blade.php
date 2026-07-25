@extends('layouts.app')

@section('page-header', 'Company Information')
@section('page-description', 'Manage your company details')

@section('content')
<div class="max-w-2xl">
    <x-card>
        <form action="{{ route('admin.company.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6">
                <div>
                    <x-input
                        label="Company Name"
                        name="company_name"
                        id="company_name"
                        :value="old('company_name', $company?->company_name ?? config('app.name'))"
                        required
                    />
                </div>

                <div>
                    <x-input
                        label="TIN / Tax Identification Number"
                        name="tin"
                        id="tin"
                        :value="old('tin', $company?->tin ?? '')"
                        placeholder="e.g., 123-456-789-000"
                    />
                </div>

                <div>
                    <x-input
                        label="Business Registration Number"
                        name="registration_number"
                        id="registration_number"
                        :value="old('registration_number', $company?->registration_number ?? '')"
                    />
                </div>

                <div>
                    <x-textarea
                        label="Address"
                        name="address"
                        id="address"
                        :value="old('address', $company?->address ?? '')"
                        rows="3"
                    />
                </div>

                <div>
                    <x-input
                        label="Contact Email"
                        name="email"
                        id="email"
                        type="email"
                        :value="old('email', $company?->email ?? '')"
                    />
                </div>

                <div>
                    <x-input
                        label="Contact Phone"
                        name="phone"
                        id="phone"
                        :value="old('phone', $company?->phone ?? '')"
                    />
                </div>
            </div>

            <div class="flex items-center justify-end space-x-3 mt-6 pt-6 border-t border-gray-200">
                <x-button variant="primary" type="submit">
                    Save Company Information
                </x-button>
            </div>
        </form>
    </x-card>
</div>
@endsection

