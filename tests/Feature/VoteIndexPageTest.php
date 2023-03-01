<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Livewire\IdeaIndex;
use App\Http\Livewire\IdeasIndex;
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
        // $user = User::factory()->create();

        // $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        // $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        // $statusOpen = Status::factory()->create(['name' => 'Open', ]);

        // $idea = Idea::factory()->create([
        //     'user_id' => $user->id,
        //     'category_id' => $categoryOne->id,
        //     'status_id' => $statusOpen->id,
        //     'title' => 'My First Idea',
        //     'description' => 'description for my first idea',
        // ]);
        $idea = Idea::factory()->create();

        $this->get(route('idea.index'))
            ->assertSeeLivewire('idea-index');
    }

    /** @test */
    public function  ideas_index_livewire_component_correctly_receives_votes_count(){
        $user = User::factory()->create();
        $userB = User::factory()->create();
        $userC = User::factory()->create();

        $idea = Idea::factory()->create();

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

        \Livewire::test(IdeasIndex::class)
            ->assertViewHas('ideas', function($ideas){
                return $ideas->first()->votes_count == 3;
            });
    }

    /** @test */
    public function votes_count_shows_correctly_on_index_page_livewire_component(){
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open', ]);

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
        ->assertSet('votesCount', 12);
    }

    /** @test */
    public function user_who_is_logged_in_shows_voted_id_idea_already_voted_for(){
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);

        $statusOpen = Status::factory()->create(['name' => 'Open', ]);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'My First Idea',
            'description' => 'description for my first idea',
        ]);

        Vote::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $user->id
        ]);

        $idea->votes_count = 1;
        $idea->voted_by_user = 1;

        \Livewire::actingAs($user)
            ->test(IdeaIndex::class, [
            'idea' => $idea,
            'votesCount' => 5
        ])
        ->assertSet('hasVoted', true)
        ->assertSee('Voted');
    }

    /** @test */
    public function user_who_is_logged_in_can_remove_vote_for_idea(){
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);

        $statusOpen = Status::factory()->create(['name' => 'Open', ]);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'My First Idea',
            'description' => 'description for my first idea',
        ]);

        Vote::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $user->id
        ]);

        $idea->votes_count = 1;
        $idea->voted_by_user = 1;

        \Livewire::actingAs($user)
            ->test(IdeaIndex::class, [
            'idea' => $idea,
            'votesCount' => 5
        ])
        ->call('vote')
        ->assertSet('votesCount', 4)
        ->assertSet('hasVoted', false)
        ->assertSee('Vote')
        ->assertDontSee('Voted');
    }
}
