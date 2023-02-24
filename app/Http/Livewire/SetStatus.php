<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Idea;
use Illuminate\Http\Response;
use App\Mail\IdeaStatusUpdatedMailable;

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
            $this->notifyAllVoters();
        }

        $this->emit('statusWasUpdated', $this->status);
    }

    public function notifyAllVoters(){
        $this->idea->votes()
            ->select('name', 'email')
            ->chunk(5, function ($voters) {
                foreach($voters as $user) {
                    // send email
                    \Mail::to($user)
                        ->queue(new IdeaStatusUpdatedMailable($this->idea));
                }
            });
    }

    public function render()
    {
        return view('livewire.set-status');
    }
}
