<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Vote;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    public function index()
    {
        return view('idea.index',[
            'ideas' => Idea::with(['user', 'category', 'status'])
                ->addSelect(['voted_by_user' => Vote::select('id')
                    ->where('user_id', auth()->id())
                    ->whereColumn('idea_id', 'ideas.id')
                ])
                ->withCount('votes')
                ->orderBy('id', 'desc')
                ->simplePaginate(Idea::PAGINATION_COUNT)
        ]);
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {
        //
    }

    public function show(Idea $idea)
    {
        return view('idea.show',[
            'idea' => $idea,
            'votesCount' => $idea->votes()->count()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        //
    }
}
