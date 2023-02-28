<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Comment;

class IdeaComment extends Component
{
    public $comment;

    public function mount(Comment $comment){
        $this->comment = $comment;
    }

    public function render()
    {
        return view('livewire.idea-comment');
    }
}
