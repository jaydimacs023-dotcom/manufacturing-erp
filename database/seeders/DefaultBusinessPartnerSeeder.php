<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DefaultBusinessPartnerSeeder extends Seeder
{
    public function run(): void
    {
        // Get the payment term IDs
        $cashTerm = DB::table('payment_terms')->where('term_code', 'CASH')->first();
        $net30Term = DB::table('payment_terms')->where('term_code', 'NET30')->first();

        $partners = [
            [
                'uuid' => (string) Str::uuid(),
                'partner_code' => 'SUP-2026-000001',
                'partner_name' => 'Saba Banana Farm Cooperative',
                'partner_type' => 'supplier',
                'tax_identification_number' => 'TIN-1234-5678',
                'address' => 'Brgy. San Jose, Talisay City, Negros Occidental',
                'country' => 'Philippines',
                'phone' => '+63 34 456 7890',
                'email' => 'info@sababananafarm.coop',
                'payment_term_id' => $net30Term?->id ?? null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'partner_code' => 'SUP-2026-000002',
                'partner_name' => 'Visayas Packaging Solutions Inc.',
                'partner_type' => 'supplier',
                'tax_identification_number' => 'TIN-2345-6789',
                'address' => 'Mandaue City, Cebu',
                'country' => 'Philippines',
                'phone' => '+63 32 345 6789',
                'email' => 'sales@visayaspackaging.com',
                'payment_term_id' => $net30Term?->id ?? null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'partner_code' => 'SUP-2026-000003',
                'partner_name' => 'Mega Oil Trading Corp.',
                'partner_type' => 'supplier',
                'tax_identification_number' => 'TIN-3456-7890',
                'address' => 'Cagayan de Oro City, Misamis Oriental',
                'country' => 'Philippines',
                'phone' => '+63 88 234 5678',
                'email' => 'orders@megaoil.com',
                'payment_term_id' => $net30Term?->id ?? null,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'partner_code' => 'CUS-2026-000001',
                'partner_name' => 'Metro Manila Distributors Inc.',
                'partner_type' => 'customer',
                'tax_identification_number' => 'TIN-4567-8901',
                'address' => 'Quezon City, Metro Manila',
                'country' => 'Philippines',
                'phone' => '+63 2 8901 2345',
                'email' => 'purchasing@metromaniladist.com',
                'payment_term_id' => $cashTerm?->id ?? null,
                'credit_limit' => 500000.00,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'partner_code' => 'CUS-2026-000002',
                'partner_name' => 'Davao Premium Foods Trading',
                'partner_type' => 'customer',
                'tax_identification_number' => 'TIN-5678-9012',
                'address' => 'Davao City, Davao del Sur',
                'country' => 'Philippines',
                'phone' => '+63 82 567 8901',
                'email' => 'orders@davaopremiumfoods.com',
                'payment_term_id' => $net30Term?->id ?? null,
                'credit_limit' => 300000.00,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'partner_code' => 'CUS-2026-000003',
                'partner_name' => 'Japan Food Export Co. Ltd.',
                'partner_type' => 'customer',
                'tax_identification_number' => 'JP-12345-6789',
                'address' => 'Chuo-ku, Tokyo, Japan',
                'country' => 'Japan',
                'phone' => '+81 3 1234 5678',
                'email' => 'procurement@japanfoodexport.jp',
                'payment_term_id' => $net30Term?->id ?? null,
                'credit_limit' => 1000000.00,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('business_partners')->insert($partners);
    }
}
