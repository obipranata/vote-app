<?php

namespace App\Http\Livewire;

use Livewire\Component;

class IdeaIndex extends Component
{
    public $idea;

    public function mount($idea){
        $this->idea = $idea;
    }

    public function render()
    {
        return view('livewire.idea-index');
    }
}
