<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Exceptions\VoteNotFoundException;
use App\Exceptions\DuplicateVoteException;
use App\Http\Livewire\Traits\WithAuthRedirects;

class IdeaIndex extends Component
{
    use WithAuthRedirects;
    
    public $idea;
    public $votesCount;
    public $hasVoted;

    public function mount($idea, $votesCount){
        $this->idea = $idea;
        $this->votesCount = $votesCount;
        $this->hasVoted = $idea->voted_by_user;
    }

    public function vote(){
        if(auth()->guest()){
            return $this->redirectToLogin();
        }

        if($this->hasVoted){
            try {
                $this->idea->removeVote(auth()->user());
            }catch(VoteNotFoundException $e){
                // do nothing
            }
            $this->votesCount--;
            $this->hasVoted = false;
        }else{
            try{
                $this->idea->vote(auth()->user());
            }catch(DuplicateVoteException $e){
                // do nothing
            }
            $this->votesCount++;
            $this->hasVoted = true;
        }
    }

    public function render()
    {
        return view('livewire.idea-index');
    }
}
