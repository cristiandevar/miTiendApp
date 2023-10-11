<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Carousel;

class CarouselSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $txt = '/img/galeria/imagen';
        Carousel::factory()->create([
            'url' => $txt . '01.jpg',
            'title' => 'Doha Port Stadium',
            'description' => 'Capacidad: 44950',
            'priority' => 1,
        ]);
        Carousel::factory()->create([
            'url' => $txt . '02.jpg',
            'title' => 'Al-Gharrafa Stadium',
            'description' => 'Capacidad: 44740',
            'priority' => 2,
        ]);
        Carousel::factory()->create([
            'url' => $txt . '03.jpg',
            'title' => 'Al-Shamal Stadium',
            'description' => 'Capacidad: 45120',
            'priority' => 3,
        ]);
        Carousel::factory()->create([
            'url' => $txt . '04.jpg',
            'title' => 'Al-Khor Stadium',
            'description' => 'Capacidad: 45330',
            'priority' => 4,
        ]);
        Carousel::factory()->create([
            'url' => $txt . '05.jpg',
            'title' => 'Qatar University Stadium',
            'description' => 'Capacidad: 43520',
            'priority' => 5,
        ]);
    }
}
