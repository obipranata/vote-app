<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Idea;
use App\Models\Vote;
use App\Models\Comment;
use Illuminate\Http\Response;

class DeleteIdea extends Component
{
    public $idea;

    public function mount(Idea $idea){
        $this->idea = $idea;
    }

    public function deleteIdea(){
        // Authorization
        if (auth()->guest() || auth()->user()->cannot('delete', $this->idea)){
            abort(Response::HTTP_FORBIDDEN);
        }

        // Vote::where('idea_id', $this->idea->id)->delete();
        // Comment::where('idea_id', $this->idea->id)->delete();
        Idea::destroy($this->idea->id);

        session()->flash('success_message', 'Idea was deleted successfully!');
        
        return redirect()->route('idea.index');
    }

    public function render()
    {
        return view('livewire.delete-idea');
    }
}
