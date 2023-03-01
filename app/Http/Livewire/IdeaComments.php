<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Idea;
use App\Models\Comment;
use Livewire\WithPagination;

class IdeaComments extends Component
{
    use WithPagination;
    public $idea;

    protected $listeners = ['commentWasAdded', 'commentWasDeleted', 'statusWasUpdated'];

    public function mount(Idea $idea){
        $this->idea = $idea;
    }

    public function commentWasAdded(){
        $this->idea->refresh();
        $this->goToPage($this->idea->comments()->paginate()->lastPage());
    }
    public function statusWasUpdated(){
        $this->idea->refresh();
        $this->goToPage($this->idea->comments()->paginate()->lastPage());
    }
    public function commentWasDeleted(){
        $this->idea->refresh();
        $this->goToPage(1);
    }

    public function render()
    {
        return view('livewire.idea-comments', [
            // 'comments' => $this->idea->comments()->paginate()->withQueryString(),
            'comments' => Comment::with(['user', 'status'])->where('idea_id', $this->idea->id)->paginate()->withQueryString(),
        ]);
    }
}
