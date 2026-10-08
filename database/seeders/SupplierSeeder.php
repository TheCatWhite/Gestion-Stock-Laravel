<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::factory()->create([
            'name' => 'Supplier 5',
            'email' => 'supplier8@example.com',
            'phone' => '1234565890',
            'address' => '1235567890',
        ]);
    }
}
