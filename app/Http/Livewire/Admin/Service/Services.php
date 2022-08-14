<?php

namespace App\Http\Livewire\Admin\Service;

use Livewire\Component;
use App\Models\Service as ServiceModal ;
use Livewire\WithFileUploads;


class Services extends Component
{
    use WithFileUploads;
    public $page = 'Services';
    public function render()
    {
        return view('livewire.admin.service.services');
    }

    public $title,$slug,$image,$status,
    $description,$modalData,$modalStatus,$image_thumbnail="";

    public $curPage = 'Service';
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
        $customRule = $this->recordId == 0 ? 'required' : 'required|exists:services,id';
        $arr = [
            'recordId' => $customRule,
            'title' => 'required|max:255',
            'slug' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'description' => 'nullable|max:255',
        ];
        return $arr;
    } 

    protected $listeners = ['view','edit'];


    public function view($id)
    {
        $service = ServiceModal::where('status',1)
        ->where('id',$id)
        ->first();
        if($service == null){
            $this->dispatchBrowserEvent('alert',error('Service not found'));
            return;
        }
        $this->modalData = $service;
        $this->modalStatus = $service->status;
        $this->dispatchBrowserEvent('viewModal');
    }

    public function edit($id)
    {
        $service = ServiceModal::where('id',$id)->select('*')->first();
        if($service == null){
            $this->dispatchBrowserEvent('alert',error('Service not found'));
            return;
        }
        $this->recordId = $id;
        $this->title = $service->title;
        $this->slug = $service->slug;
        $this->image_thumbnail= $service->image;
        $this->description = $service->description;
        $this->dispatchBrowserEvent('addUpdateModal');
    }
   

    public function viewAddModal()
    {
        $this->recordId = 0;
        $this->name = '';
        $this->reset(['description','title','image','slug','title']);
        $this->dispatchBrowserEvent('addUpdateModal');
    }

    public function submit() 
    {
        $param = $this->validate();
        if($param['image'] != null){
            $param['image'] = $this->image->store('services/image', 'userPublic');
        }else{
            unset($param['image']);
        }
        $service = ServiceModal::updateOrCreate(['id' =>$param['recordId'] ],$param);
        $res = $param['recordId'] != 0 ? success('Service Updated successfully.') : success('Service added successfully.');
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
