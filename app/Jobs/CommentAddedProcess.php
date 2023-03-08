<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Notifications\CommentAdded;
use App\Mail\CommentAddedMailable;
use App\Models\Comment;

class CommentAddedProcess implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $comment;
    public $email;
    public function __construct($email, Comment $comment)
    {
        $this->comment = $comment;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \Mail::to($this->email)
        ->queue(new CommentAddedMailable($this->comment));
    }
}
