<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\MemberModel;
use Carbon\Carbon;

class Member extends Component
{
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
        'contactUpdated' => 'handleUpdated'
    ];

    protected $queryString= ['search'];

    public function mount()
    {
        $this->search = request()->query('search' , $this->search );
    }
    
    public function changeDate()
    {
        $date = Carbon::createFromDate($this->fromDate)->format('Y-m-d');
        $afterParse = Carbon::parse($date);
        $newResult =  $afterParse->addDays(30)->format('Y-m-d');
        $newResultMinDate =  $afterParse->subDays(30)->format('Y-m-d');
        $this->minDate = $afterParse->format('Y-m-d');  
        $this->maxDate = $newResult;
        $this->toDate = $newResult;
    }
    public function render()
    {
        // $data = MemberModel::query();
        
        // if($this->startDate && $this->endDate && $this->enableSearch)
        // {
        //     $this->startDate = Carbon::createFromDate($this->startDate)->format('Y-m-d');
        //     $this->endDate = Carbon::parse($this->endDate)->format('Y-m-d');
        //     $newResult = $startDate->addDays(30);
        //     $endDate->subDays(30); 
        //     $this->minDate = $startDate->format('Y-m-d');

        //     $this->maxDate = $newResult;
        //     $this->endDate = $newResult;

        // }
        return view('livewire.member' , [
            'member' => $this->search == null ?
            MemberModel::latest()->paginate($this->paginate) :
            MemberModel::latest()->where('name','like','%'.$this->search.'%')->paginate($this->paginate) ,
            'member' => MemberModel::paginate(20),
        ]);
    }
    public function search()
    {
        $this->enableSearch = true;
        
    }
    public function getMember($id) 
    {
        $this->statusUpdate = true;
        $member = MemberModel::find($id);
        $this->emit('getMember' , $member);
    }
    
    public function destroy()
    {
        if($id){
            $data = MemberModel::find($id);
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
