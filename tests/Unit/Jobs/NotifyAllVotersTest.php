<?php

namespace Tests\Unit\Jobs;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Jobs\NotifyAllVoters;
use App\Mail\IdeaStatusUpdatedMailable;
use App\Models\Category;
use App\Models\Status;
use App\Models\User;
use App\Models\Idea;
use App\Models\Vote;


class NotifyAllVotersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sends_an_email_to_all_voters(){
        $user = User::factory()->create([
            'email' => 'obi@gmail.com'
        ]);
        $userB = User::factory()->create([
            'email' => 'user@gmail.com'
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

        Vote::create([
            'idea_id' => $idea->id,
            'user_id' => $user->id,
        ]);
        Vote::create([
            'idea_id' => $idea->id,
            'user_id' => $userB->id,
        ]);

        \Mail::fake();

        NotifyAllVoters::dispatch($idea);

        \Mail::assertQueued(IdeaStatusUpdatedMailable::class, function($mail){
            return $mail->hasTo('obi@gmail.com')
                && $mail->envelope()->subject === 'An idea you voted for has a new status';
        });

        \Mail::assertQueued(IdeaStatusUpdatedMailable::class, function($mail){
            return $mail->hasTo('user@gmail.com')
                && $mail->envelope()->subject === 'An idea you voted for has a new status';
        });
    }
}
