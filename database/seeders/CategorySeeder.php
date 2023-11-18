<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Ropa',
            'active' => 1
        ]);
        Category::create([
            'name' => 'Mercaderia',
            'active' => 1
        ]);
        Category::create([
            'name' => 'Bazar',
            'active' => 1
        ]);
        Category::create([
            'name' => 'Limpieza',
            'active' => 1
        ]);
        Category::create([
            'name' => 'Cotillón',
            'active' => 1
        ]);
    }
}
