<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Idea;
use App\Models\Comment;
use Illuminate\Http\Response;
use App\Notifications\CommentAdded;

class AddComment extends Component
{
    public $idea;
    public $comment;
    protected $rules = [
        'comment' => 'required|min:4'
    ];

    public function mount(Idea $idea){
        $this->idea = $idea;
    }

    public function addComment()
    {
        // Authorization
        if (auth()->guest()){
            abort(Response::HTTP_FORBIDDEN);
        }

        $this->validate();

        $newComment = Comment::create([
            'user_id' => auth()->user()->id,
            'idea_id' => $this->idea->id,
            'status_id' => 1,
            'body' => $this->comment
        ]);

        $this->reset('comment'); 
        
        $this->idea->user->notify(new CommentAdded($newComment));
        $this->emit('commentWasAdded', 'Comment was posted!');

    }

    public function render()
    {
        return view('livewire.add-comment');
    }
}
