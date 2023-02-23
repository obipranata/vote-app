<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Http\Livewire\IdeaShow;
use App\Models\User;
use App\Models\Category;
use App\Models\Status;
use App\Models\Idea;
use App\Models\Vote;

class VoteShowPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function  show_page_contains_idea_show_livewire_component(){
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

        $this->get(route('idea.show', $idea))
            ->assertSeeLivewire('idea-show');
    }

    /** @test */
    public function  show_page_correctly_receives_votes_count(){
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

        $this->get(route('idea.show', $idea))
            ->assertViewHas('votesCount', 3);
    }

    /** @test */
    public function votes_count_shows_correctly_on_show_page_livewire_component(){
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

        \Livewire::test(IdeaShow::class, [
            'idea' => $idea,
            'votesCount' => 0
        ])
        ->assertSet('votesCount', 0);
    }

    /** @test */
    public function user_who_is_logged_in_shows_voted_id_idea_already_voted_for(){
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);

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
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)->get(route('idea.index'));

        $ideaWithVotes = $response['ideas']->items()[0];

        \Livewire::actingAs($user)
            ->test(IdeaShow::class, [
            'idea' => $ideaWithVotes,
            'votesCount' => 5
        ])
        ->assertSet('hasVoted', true)
        ->assertSee('Voted');
    }

    /** @test */
    public function user_who_is_not_logged_in_is_redirected_to_login_page_when_trying_to_vote(){
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);

        $statusOpen = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'My First Idea',
            'description' => 'description for my first idea',
        ]);

        \Livewire::test(IdeaShow::class, [
            'idea' => $idea,
            'votesCount' => 5
        ])
        ->call('vote', true)
        ->assertRedirect(route('login'));
    }

    /** @test */
    public function user_is_not_logged_in_can_vote_for_idea(){
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);

        $statusOpen = Status::factory()->create(['name' => 'Open', 'classes' => 'bg-gray-200']);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'My First Idea',
            'description' => 'description for my first idea',
        ]);

        $this->assertDatabaseMissing('votes', [
            'user_id' => $user->id,
            'idea_id' => $idea->id
        ]);

        \Livewire::actingAs($user)
            ->test(IdeaShow::class, [
            'idea' => $idea,
            'votesCount' => 5
        ])
        ->call('vote', true)
        ->assertSet('votesCount', 6)
        ->assertSet('hasVoted', true)
        ->assertSee('Voted');

        $this->assertDatabaseHas('votes', [
            'user_id' => $user->id,
            'idea_id' => $idea->id
        ]);
    }
}
