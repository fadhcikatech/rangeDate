<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\User;
use App\Tag;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Livewire\WithPagination;

class Member extends Component
{
    use WithPagination;

    public $statusUpdate = false;
    public $paginate = 20;
    public $search;
    public $enableSearch = false;
    public $startDate;
    public $endDate;
    public $minDate;
    public $maxDate;

    protected $listeners = [
        'contactStored' => 'handleStored',
        'contactUpdated' => 'handleUpdated',
        'changeDateValue' => 'changeDate'
    ];

    protected $queryString= ['search'];

    public function mount()
    {
        $this->search = request()->query('search' , $this->search );
    }
    
    public function changeDate()
    {
        $date = Carbon::createFromFormat('Y-m-d', $this->startDate);
        $afterParse = Carbon::parse($date);
        $newResult =  $afterParse->addDays(30)->format('Y-m-d');
        $afterParse->subDays(30)->format('Y-m-d');
        $this->minDate = $afterParse->format('Y-m-d');  
        
        $this->maxDate = $newResult;
        $this->endDate = $newResult;

        if($date->month == now()->month )
        {
            $this->endDate = now()->format('Y-m-d');
            $this->dispatchBrowserEvent('changeDateValue' , [
                'maxDate' => now()->format('Y-m-d'),
                'minDate' => $this->minDate
            ]);
            return;
        } elseif ($date->month !== now()->month)
        {
            
            $this->endDate = now()->format('Y-m-d');
            $this->dispatchBrowserEvent('changeDateValue' , [
                'maxDate' => now()->format('Y-m-d'),
                'minDate' => $this->minDate
            ]);
            return;
        }
        $this->dispatchBrowserEvent('changeDateValue' , [
            'maxDate' => $this->maxDate,
            'minDate' => $this->minDate
        ]);
    }

    public function render()
    {
        $this->maxDate = Carbon::parse($this->startDate)->format('Y-m-d');
        $this->minDate = Carbon::now()->subDays(30)->format('Y-m-d');
        //  dd($this->maxDate , $this->minDate);
        //query
        $query = User::query();
        $this->startDate = Carbon::parse($this->startDate)->format('Y-m-d');
        $this->endDate = Carbon::parse($this->endDate)->format('Y-m-d');
        // dd($startDate , $endDate);
        if ($this->endDate && $this->startDate && $this->statusUpdate && $this->enableSearch)
        {
            $query->where(function ($last) use ($startDate, $endDate){
                $last->whereBetween('users.created_at' , [$startDate , $endDate]);
            });
            return;
            // dd($query);
        }
        else
        {
            $query->where(function ($last) {
                $last->whereBetween('users.created_at' , [now() , now()]);
            });
        }
        // $detailData = $query()->get();

        
        return view('livewire.member' , [
            'member' => $this->search == null ?
            User::latest()->paginate($this->paginate) :
            User::latest()->where('name','like','%'.$this->search.'%')->paginate($this->paginate) ,
            'member' => User::paginate(20),
        ]);
    }
    public function search()
    {
        $this->enableSearch = true;
        
    }
    public function getMember($id) 
    {
        $this->statusUpdate = true;
        $member = User::find($id);
        $this->emit('getMember' , $member);
    }
    
    public function destroy()
    {
        if($id){
            $data = User::find($id);
            $data->delete;
            session()->flash('message' , 'Data Has Been Delete');
        }
    }
    
    public function handleStored($member)
    {
        session()->flash('message' , 'Member'. $member['name'] . 'Was Stored ');
    }
    
    public function handleUpdated($member)
    {
        session()->flash('message' , 'Member' . $member['name'] . 'Was Updated');
        $this->statusUpdate = false;
    }

}
