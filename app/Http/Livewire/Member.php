<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\MemberModel;

class Member extends Component
{
    public $statusUpdate = false;
    public $paginate = 20;
    public $search;
    
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
        return view('livewire.member' , [
            'member' => $this->search == null ?
            MemberModel::latest()->paginate($this->paginate) :
            MemberModel::latest()->where('name','like','%'.$this->search.'%')->paginate($this->paginate) ,
            'member' => MemberModel::paginate(20),
        ]);
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
