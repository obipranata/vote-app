<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Idea;
use Illuminate\Http\Response;
use App\Jobs\NotifyAllVoters;

class SetStatus extends Component
{
    public $idea;
    public $status;
    public $notifyAllVoters;

    public function mount(Idea $idea){
        $this->idea = $idea;
        $this->status = $this->idea->status_id;
    }

    public function setStatus(){
        if(! auth()->check() || ! auth()->user()->isAdmin()){
            abort(Response::HTTP_FORBIDDEN);
        }
        $this->idea->status_id = $this->status;
        $this->idea->save();

        if($this->notifyAllVoters){
            NotifyAllVoters::dispatch($this->idea);
        }

        $this->emit('statusWasUpdated', $this->status, 'Status was updated successfully!');
    }

    public function render()
    {
        return view('livewire.set-status');
    }
}
