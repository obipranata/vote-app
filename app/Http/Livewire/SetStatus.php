<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Idea;
use App\Models\Comment;
use Illuminate\Http\Response;
use App\Jobs\NotifyAllVoters;

class SetStatus extends Component
{
    public $idea;
    public $status;
    public $comment;
    public $notifyAllVoters;

    public function mount(Idea $idea){
        $this->idea = $idea;
        $this->status = $this->idea->status_id;
    }

    public function setStatus(){
        if(! auth()->check() || ! auth()->user()->isAdmin()){
            abort(Response::HTTP_FORBIDDEN);
        }

        if($this->idea->status_id === (int) $this->status){
            $this->emit('statusWasUpdatedError', $this->status, 'Status is the same!');
            return;
        }

        $this->idea->status_id = $this->status;
        $this->idea->save();

        if($this->notifyAllVoters){
            NotifyAllVoters::dispatch($this->idea);
        }

        Comment::create([
            'user_id' => auth()->user()->id,
            'idea_id' => $this->idea->id,
            'status_id' => $this->status,
            'body' => $this->comment ?? 'No comment was added.',
            'is_status_update' => true
        ]);

        $this->emit('statusWasUpdated', $this->status, 'Status was updated successfully!');
    }

    public function render()
    {
        return view('livewire.set-status');
    }
}
