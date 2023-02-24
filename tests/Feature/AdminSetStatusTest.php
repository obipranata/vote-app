<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Livewire\SetStatus;
use Tests\TestCase;
use App\Models\Category;
use App\Models\Status;
use App\Models\User;
use App\Models\Idea;

class AdminSetStatusTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function show_page_contains_set_status_livewire_component_when_user_is_admin(){
        $user = User::factory()->create([
            'email' => 'obi@gmail.com'
        ]);

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'My First Idea',
            'description' => 'description for my first idea',
        ]);

        $this->actingAs($user)
            ->get(route('idea.show', $idea))
            ->assertSeeLivewire('set-status');
    }

    /** @test */
    public function show_page_does_not_contains_set_status_livewire_component_when_user_is_not_admin(){
        $user = User::factory()->create([
            'email' => 'user@gmail.com'
        ]);

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'My First Idea',
            'description' => 'description for my first idea',
        ]);

        $this->actingAs($user)
            ->get(route('idea.show', $idea))
            ->assertDontSeeLivewire('set-status');
    }

    /** @test */
    public function initial_status_is_set_correctly(){
        $user = User::factory()->create([
            'email' => 'obi@gmail.com'
        ]);

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'My First Idea',
            'description' => 'description for my first idea',
        ]);

        \Livewire::actingAs($user)
            ->test(SetStatus::class, [
                'idea' => $idea,
            ])
            ->assertSet('status', $statusOpen->id);
    }

    /** @test */
    public function can_set_status_correctly(){
        $user = User::factory()->create([
            'email' => 'obi@gmail.com'
        ]);

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['id'=>1,'name' => 'Open']);
        $statusConsidering = Status::factory()->create(['id'=>3,'name' => 'Considering']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'My First Idea',
            'description' => 'description for my first idea',
        ]);

        \Livewire::actingAs($user)
        ->test(SetStatus::class, [
            'idea' => $idea,
        ])
        ->set('status', $statusOpen->id)
        ->call('setStatus')
        ->assertEmitted('statusWasUpdated');

        $this->assertDatabaseHas('ideas', [
            'id' => $idea->id,
            'status_id' => $statusOpen->id,
        ]);
    }
}
