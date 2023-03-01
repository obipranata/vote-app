<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Idea;
use App\Models\Category;
use App\Models\Status;
use App\Models\Vote;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Obi Pranata',
            'email' => 'obi@gmail.com'
        ]);

        User::factory(19)->create();

        Category::factory()->create(['name' => 'Category 1']);
        Category::factory()->create(['name' => 'Category 2']);
        Category::factory()->create(['name' => 'Category 3']);
        Category::factory()->create(['name' => 'Category 4']);

        Status::factory()->create([
            'name' => 'Open',
        ]);
        Status::factory()->create([
            'name' => 'Considering',
        ]);
        Status::factory()->create([
            'name' => 'In Progress',
        ]);
        Status::factory()->create([
            'name' => 'Implemented',
        ]);
        Status::factory()->create([
            'name' => 'Closed',
        ]);
        Idea::factory(100)->existing()->create();

        // Generate unique votes. Ensure idea_id and user_id are unique for each row
        foreach(range(1,20) as $user_id){
            foreach(range(1,100) as $idea_id){
                if($idea_id % 2 === 0){
                    Vote::factory()->create([
                        'user_id' => $user_id,
                        'idea_id' => $idea_id,
                    ]);
                }
            }
        }

        // Generates comments for ideas
        foreach(Idea::all() as $idea){
            Comment::factory(5)->existing()->create(['idea_id' => $idea->id]);
        }
    }
}
