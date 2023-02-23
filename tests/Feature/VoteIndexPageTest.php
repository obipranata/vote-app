<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Livewire\IdeaIndex;
use App\Models\User;
use App\Models\Category;
use App\Models\Status;
use App\Models\Idea;
use App\Models\Vote;

class VoteIndexPageTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function  index_page_contains_idea_index_livewire_component(){
        $user = User::factory()->create();

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

        $this->get(route('idea.index'))
            ->assertSeeLivewire('idea-index');
    }

    /** @test */
    public function  index_page_correctly_receives_votes_count(){
        $user = User::factory()->create();
        $userB = User::factory()->create();
        $userC = User::factory()->create();

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

        Vote::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $user->id,
        ]);
        Vote::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $userB->id,
        ]);
        Vote::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $userC->id,
        ]);

        $this->get(route('idea.index'))
            ->assertViewHas('ideas', function($ideas){
                return $ideas->first()->votes_count == 3;
            });
    }

    /** @test */
    public function votes_count_shows_correctly_on_index_page_livewire_component(){
        $user = User::factory()->create();

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

        \Livewire::test(IdeaIndex::class, [
            'idea' => $idea,
            'votesCount' => 12
        ])
        ->assertSet('votesCount', 12)
        ->assertSeeHtml('<div class="font-semibold text-2xl">12</div>')
        ->assertSeeHtml('<div class="text-sm font-bold leading-none">12</div>');
    }
}
