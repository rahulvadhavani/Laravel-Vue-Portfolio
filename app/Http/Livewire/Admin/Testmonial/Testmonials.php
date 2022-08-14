<?php

namespace App\Http\Livewire\Admin\Testmonial;

use Livewire\Component;
use App\Models\Testimonial as TestimonialModal ;
use Livewire\WithFileUploads;


class Testmonials extends Component
{
    use WithFileUploads;
    public $page = 'Testimonials';
    public function render()
    {
        return view('livewire.admin.testimonial.testimonials');
    }

    public $name,$business,$image,$status,
    $description,$modalData,$modalStatus,$image_thumbnail;

    public $curPage = 'Testimonial';
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
        $customRule = $this->recordId == 0 ? 'required' : 'required|exists:testimonials,id';
        $arr = [
            'recordId' => $customRule,
            'name' => 'required|max:255',
            'business' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'description' => 'nullable|max:255',
        ];
        return $arr;
    } 

    protected $listeners = ['view','edit'];


    public function view($id)
    {
        $service = TestimonialModal::where('status',1)
        ->where('id',$id)
        ->first();
        if($service == null){
            $this->dispatchBrowserEvent('alert',error('Testimonial not found'));
            return;
        }
        $this->modalData = $service;
        $this->modalStatus = $service->status;
        $this->dispatchBrowserEvent('viewModal');
    }

    public function edit($id)
    {
        $service = TestimonialModal::where('id',$id)->select('*')->first();
        if($service == null){
            $this->dispatchBrowserEvent('alert',error('Testimonial not found'));
            return;
        }
        $this->recordId = $id;
        $this->name = $service->name;
        $this->business = $service->business;
        $this->image_thumbnail= $service->image;
        $this->description = $service->description;
        $this->dispatchBrowserEvent('addUpdateModal');
    }
   

    public function viewAddModal()
    {
        $this->recordId = 0;
        $this->name = '';
        $this->reset(['description','name','image','business','name']);
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
        $service = TestimonialModal::updateOrCreate(['id' =>$param['recordId'] ],$param);
        $res = $param['recordId'] != 0 ? success('Testimonial Updated successfully.') : success('Testimonial added successfully.');
        $this->dispatchBrowserEvent('close-modal');
        $this->refreshData();
        $this->recordId = 0;
        $this->reset(['description','name','image','business']);
        $this->dispatchBrowserEvent('alert',$res);
    }

    public function refreshData()
    {
        $this->emit('refresh');
    }

}
