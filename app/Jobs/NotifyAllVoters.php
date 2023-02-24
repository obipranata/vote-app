<?php

namespace App\Jobs;

use App\Models\Idea;
use App\Mail\IdeaStatusUpdatedMailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotifyAllVoters implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $idea;
    /**
     * Create a new job instance.
     */
    public function __construct(Idea $idea)
    {
        $this->idea = $idea;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->idea->votes()
        ->select('name', 'email')
        ->chunk(5, function ($voters) {
            foreach($voters as $user) {
                // send email
                \Mail::to($user)
                    ->queue(new IdeaStatusUpdatedMailable($this->idea));
            }
        });
    }
}
