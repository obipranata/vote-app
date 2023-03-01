<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Exceptions\VoteNotFoundException;
use App\Exceptions\DuplicateVoteException;

class IdeaShow extends Component
{
    public $idea;
    public $votesCount;
    public $commentsCount;
    public $hasVoted;

    protected $listeners = [
        'statusWasUpdated', 
        'ideaWasUpdated', 
        'ideaWasMarkedAsSpam', 
        'ideaWasMarkedAsNotSpam',
        'commentWasAdded',
        'commentWasDeleted',
    ];

    public function mount($idea, $votesCount, $commentsCount){
        $this->idea = $idea;
        $this->votesCount = $votesCount;
        $this->commentsCount = $commentsCount;
        $this->hasVoted = $idea->isVotedByUser(auth()->user());
    }

    public function statusWasUpdated($newStatus){
        // $this->idea->status_id = $newStatus;
        $this->idea->refresh();
    }

    public function ideaWasUpdated(){
        $this->idea->refresh();
    }

    public function ideaWasMarkedAsSpam(){
        $this->idea->refresh();
    }

    public function ideaWasMarkedAsNotSpam(){
        $this->idea->refresh();
    }

    public function commentWasAdded(){
        $this->commentsCount++;
    }
    public function commentWasDeleted(){
        $this->commentsCount--;
    }

    public function vote(){
        if(! auth()->check()){
            return redirect(route('login'));
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
        return view('livewire.idea-show');
    }
}
