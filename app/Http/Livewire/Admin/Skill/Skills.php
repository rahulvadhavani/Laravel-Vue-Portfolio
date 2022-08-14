<?php

namespace App\Http\Livewire\Admin\Skill;

use Livewire\Component;
use App\Models\Skill as SkillModal;
use Livewire\WithFileUploads;


class Skills extends Component
{
    use WithFileUploads;
    public $page = 'Skills';
    public function render()
    {
        return view('livewire.admin.skill.index');
    }

    public $title,$slug,$image,$status,$percentage,$color,
    $description,$modalData,$modalStatus,$image_thumbnail="";

    public $curPage = 'Skills';
    public $recordId = 0;


    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
    
    
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    protected function rules()
    {
        $customRule = $this->recordId == 0 ? 'required' : 'required|exists:skills,id';
        $arr = [
            'recordId' => $customRule,
            'title' => 'required|max:255',
            'slug' => 'required|max:255',
            'percentage' => 'required|numeric',
            'color' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'description' => 'nullable|max:255',
        ];
        return $arr;
    } 

    protected $listeners = ['view','edit'];


    public function view($id)
    {
        $Skill = SkillModal::where('status',1)
        ->where('id',$id)
        ->first();
        if($Skill == null){
            $this->dispatchBrowserEvent('alert',error('Skill not found'));
            return;
        }
        $this->modalData = $Skill;
        $this->modalStatus = $Skill->status;
        $this->dispatchBrowserEvent('viewModal');
    }

    public function edit($id)
    {
        $Skill = SkillModal::where('id',$id)->select('*')->first();
        if($Skill == null){
            $this->dispatchBrowserEvent('alert',error('Skill not found'));
            return;
        }
        $this->recordId = $id;
        $this->title = $Skill->title;
        $this->slug = $Skill->slug;
        $this->percentage  = $Skill->percentage;
        $this->color  = $Skill->color;
        $this->image_thumbnail= $Skill->image;
        $this->description = $Skill->description;
        $this->dispatchBrowserEvent('addUpdateModal');
    }
   

    public function viewAddModal()
    {
        $this->recordId = 0;
        $this->name = '';
        $this->reset(['description','title','image','slug','title','percentage','color']);
        $this->dispatchBrowserEvent('addUpdateModal');
    }

    public function submit() 
    {
        $param = $this->validate();
        if($param['image'] != null){
            $param['image'] = $this->image->store('skills/image', 'userPublic');
        }else{
            unset($param['image']);
        }
        $Skill = SkillModal::updateOrCreate(['id' =>$param['recordId'] ],$param);
        $res = $param['recordId'] != 0 ? success('Skill Updated successfully.') : success('Skill added successfully.');
        $this->dispatchBrowserEvent('close-modal');
        $this->refreshData();
        $this->recordId = 0;
        $this->reset(['description','title','image','slug','title']);
        $this->dispatchBrowserEvent('alert',$res);
    }
    
    public function updateSlag()
    {
        $this->slug = \Str::slug($this->title);
    }

    public function refreshData()
    {
        $this->emit('refresh');
    }

}
