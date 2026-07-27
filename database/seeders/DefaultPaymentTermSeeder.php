<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DefaultPaymentTermSeeder extends Seeder
{
    public function run(): void
    {
        $terms = [
            [
                'uuid' => (string) Str::uuid(),
                'term_code' => 'CASH',
                'term_name' => 'Cash',
                'description' => 'Payment due immediately upon receipt.',
                'due_days' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'term_code' => 'COD',
                'term_name' => 'Cash on Delivery',
                'description' => 'Payment due upon delivery of goods.',
                'due_days' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'term_code' => 'NET7',
                'term_name' => '7 Days',
                'description' => 'Payment due within 7 days from invoice date.',
                'due_days' => 7,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'term_code' => 'NET15',
                'term_name' => '15 Days',
                'description' => 'Payment due within 15 days from invoice date.',
                'due_days' => 15,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'term_code' => 'NET30',
                'term_name' => '30 Days',
                'description' => 'Payment due within 30 days from invoice date.',
                'due_days' => 30,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'term_code' => 'NET60',
                'term_name' => '60 Days',
                'description' => 'Payment due within 60 days from invoice date.',
                'due_days' => 60,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => (string) Str::uuid(),
                'term_code' => 'ADVANCE',
                'term_name' => 'Advance Payment',
                'description' => 'Full payment required before order processing.',
                'due_days' => 0,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($terms as $term) {
            DB::table('payment_terms')->updateOrInsert(
                ['term_code' => $term['term_code']],
                $term
            );
        }
    }
}
