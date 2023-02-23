<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\VoteNotFoundException;
use App\Exceptions\DuplicateVoteException;

class Idea extends Model
{
    use HasFactory, Sluggable;
    protected $guarded = [];
    const PAGINATION_COUNT = 10;

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function status(){
        return $this->belongsTo(Status::class);
    }

    public function votes()
    {
        return $this->belongsToMany(User::class, 'votes');
    }

    public function isVotedByUser(?User $user){
        if(!$user){
            return false;
        }
        return Vote::where('user_id', $user->id)
            ->where('idea_id', $this->id)
            ->exists();
    }

    public function vote(User $user){
        if($this->isVotedByUser($user)){
            throw new DuplicateVoteException;
        }
        Vote::create([
            'idea_id' => $this->id,
            'user_id' => $user->id
        ]);
    }

    public function removeVote(User $user){
        $voteToDelete = Vote::where('idea_id', $this->id)
            ->where('user_id', $user->id)
            ->first();

        if($voteToDelete){
            $voteToDelete->delete();
        }else{
            throw new VoteNotFoundException;
        }

    }

}
