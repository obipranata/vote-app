<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Comment;

class IdeaComment extends Component
{
    public $comment;
    public $ideaUserId;
    
    protected $listeners = ['commentWasUpdated'];

    public function commentWasUpdated(){
        $this->comment->refresh();
    }

    public function mount(Comment $comment, $ideaUserId){
        $this->comment = $comment;
        $this->ideaUserId = $ideaUserId;
    }

    public function render()
    {
        return view('livewire.idea-comment');
    }
}
