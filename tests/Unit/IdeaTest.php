<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Exceptions\VoteNotFoundException;
use App\Exceptions\DuplicateVoteException;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Status;
use App\Models\Idea;
use App\Models\Vote;

class IdeaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_check_if_idea_is_voted_for_by_user()
    {
        $user = User::factory()->create();
        $userB = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open',]);

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

        $this->assertTrue($idea->isVotedByUser($user));
        $this->assertFalse($idea->isVotedByUser($userB));
    }

    /** @test */
    public function user_can_vote_for_idea()
    {
        $user = User::factory()->create();
        $userB = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open',]);

        $idea = Idea::factory()->create([
            'user_id' => $user->id,
            'category_id' => $categoryOne->id,
            'status_id' => $statusOpen->id,
            'title' => 'My First Idea',
            'description' => 'description for my first idea',
        ]);

        $this->assertFalse($idea->isVotedByUser($user));
        $idea->vote($user);
        $this->assertTrue($idea->isVotedByUser($user));
    }

        /** @test */
        public function voting_for_an_idea_thats_already_voted_for_throws_exception()
        {
            $user = User::factory()->create();
            $userB = User::factory()->create();
    
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

            Vote::factory()->create([
                'idea_id' => $idea->id,
                'user_id' => $user->id
            ]);
    
            $this->expectException(DuplicateVoteException::class);
            $idea->vote($user);
        }

    /** @test */
    public function user_can_remove_vote_for_idea()
    {
        $user = User::factory()->create();

        $categoryOne = Category::factory()->create(['name' => 'Category 1']);
        $categoryTwo = Category::factory()->create(['name' => 'Category 2']);

        $statusOpen = Status::factory()->create(['name' => 'Open',]);

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

        $this->assertTrue($idea->isVotedByUser($user));
        $idea->removeVote($user);
        $this->assertFalse($idea->isVotedByUser($user));
    }

        /** @test */
        public function removing_a_vote_that_doesnt_exist_throws_exception()
        {
            $user = User::factory()->create();
            $userB = User::factory()->create();
    
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
    
            $this->expectException(VoteNotFoundException::class);
            $idea->removeVote($user);
        }
}
