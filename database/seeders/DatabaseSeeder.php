<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Idea;
use App\Models\Category;
use App\Models\Status;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        Category::factory()->create(['name' => 'Category 1']);
        Category::factory()->create(['name' => 'Category 2']);
        Category::factory()->create(['name' => 'Category 3']);
        Category::factory()->create(['name' => 'Category 4']);

        Status::factory()->create([
            'name' => 'Open',
            'classes' => 'bg-gray-200',
        ]);
        Status::factory()->create([
            'name' => 'Considering',
            'classes' => 'bg-purple text-white',
        ]);
        Status::factory()->create([
            'name' => 'In Progress',
            'classes' => 'bg-yellow text-white',
        ]);
        Status::factory()->create([
            'name' => 'Implemented',
            'classes' => 'bg-green text-white',
        ]);
        Status::factory()->create([
            'name' => 'Closed',
            'classes' => 'bg-red text-white'
        ]);
        Idea::factory(30)->create();
    }
}
