<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Supplier::factory(5)->create();
        Supplier::create([
            'companyname' => 'PAW 2023',
            'email' => 'cristianprogramadorunsa@gmail.com',
            'phone' => '387-111-222',
            'address' => 'Av. Siempre viva 742',
            'active' => 1,
        ]);
    }
}
