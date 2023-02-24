<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Route;
use App\Models\Idea;
use App\Models\Status;

class StatusFilters extends Component
{
    public $status;
    public $statusCount;

    public function mount(){

        $this->statusCount = Status::getCount();
        $this->status = request()->status ?? 'All';

        if(Route::currentRouteName() === 'idea.show'){
            $this->status = null;
        }
    }

    public function setStatus($newStatus){
        $this->status = $newStatus;
        $this->emit('queryStringUpdatedStatus', $this->status);

        if($this->getPreviousName() === 'idea.show'){
            return redirect()->route('idea.index', [
                'status' => $this->status
            ]);
        }
    }

    public function render()
    {
        return view('livewire.status-filters');
    }

    private function getPreviousName(){
        return app('router')->getRoutes()->match(app('request')->create(url()->previous()))->getName();
    }
}
