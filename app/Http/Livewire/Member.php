<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\MemberModel;

class Member extends Component
{
    public $statusUpdate = false;
    public $paginate = 20;
    public $search;
    public $enableSearch = false;
    public $startDate;
    public $endDate;
    public $minDate;
    
    protected $listeners = [
        'contactStored' => 'handleStored',
        'contactUpdated' => 'handleUpdated'
    ];

    protected $queryString= ['search'];

    public function mount()
    {
        $this->search = request()->query('search' , $this->search );
    }
    
    public function render()
    {
        $data = MemberModel::query();
        
        if($this->startDate && $this->endDate && $this->enableSearch)
        {
            $this->startDate = Carbon::createFromDate($this->startDate)->format('Y-m-d');
            $this->endDate = Carbon::parse($this->endDate)->format('Y-m-d');
            $newResult = $startDate->addDays(30);
            $endDate->subDays(30); 
            
        }
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
