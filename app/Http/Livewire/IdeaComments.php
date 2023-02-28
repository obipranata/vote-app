<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Idea;

class IdeaComments extends Component
{
    public $idea;

    protected $listeners = ['commentWasAdded'];

    public function mount(Idea $idea){
        $this->idea = $idea;
    }

    public function commentWasAdded(){
        $this->idea->refresh();
    }

    public function render()
    {
        return view('livewire.idea-comments', [
            'comments' => $this->idea->comments,
        ]);
    }
}
