<?php

namespace App\Http\Livewire\Admin\Project;

use Livewire\Component;
use App\Models\Category;
use App\Models\Project;
use Livewire\WithFileUploads;


class Projects extends Component
{
    use WithFileUploads;
    public $page = 'Projects';
    public function render()
    {
        return view('livewire.admin.project.index');
    }

    public $title,$slug,$category_id,$start_date,$image,$status,$team_size,
    $end_date,$description,$technologies,$modalData,$modalStatus,
    $categories,$technologiesArr,$previewImage,$project_url,$source_code;

    public $curPage = 'Project';
    public $recordId = 0;

    public function mount()
    {
        $this->categories = Category::getCategories();
    }

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

        $customRule = $this->recordId == 0 ? 'required' : 'required|exists:projects,id';
        $imageCustomRule = $this->recordId == 0 ? 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048' : 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048';
        $arr = [
            'recordId' => $customRule,
            'title' => 'required|max:255',
            'slug' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'team_size' => 'required|integer',
            'image' => $imageCustomRule,
            'technologies' => 'required',
            'description' => 'required',
            'project_url' => 'nullable|url',
            'source_code' => 'nullable|url',
            'start_date' => 'nullable:end_date|date_format:Y-m-d',
            'end_date' => 'nullable|date_format:Y-m-d|after_or_equal:start_date',
        ];
        return $arr;
    } 

    protected $listeners = ['view','edit'];


    public function view($id)
    {
        $project = Project::with([
            'category'=> function($query){
                $query->select('id','name','alias');
            }
        ])->where('id',$id)
        ->select('id','category_id','title','slug','start_date','image','status','created_at','end_date','team_size','description','technologies','project_url','source_code')
        ->first();
        if($project == null){
            $this->dispatchBrowserEvent('alert',error('Project not found'));
            return;
        }
        $project->status = Project::STATUSARR[$project->status];
        $this->modalData = $project;
        $this->modalStatus = $project->status;
        $this->dispatchBrowserEvent('viewModal');
    }

    public function edit($id)
    {
        $project = project::where('id',$id)->select('*')->first();
        if($project == null){
            $this->dispatchBrowserEvent('alert',error('project not found'));
            return;
        }
        $this->recordId = $id;
        $this->title = $project->title;
        $this->slug = $project->slug;
        $this->category_id = $project->category_id;
        $this->start_date = $project->start_date;
        $this->previewImage = $project->image;
        $this->end_date = $project->end_date;
        $this->team_size = $project->team_size;
        $this->description = $project->description;
        $this->technologiesArr = $project->technologies;
        $this->project_url = $project->project_url;
        $this->source_code = $project->source_code;
        $this->technologies = implode(',',$project->technologies);
        $this->dispatchBrowserEvent('addUpdateModal');
    }

    public function viewAddModal()
    {
        $this->recordId = 0;
        $this->name = '';
        $this->reset(['technologies','description','start_date','image','end_date','category_id','slug','title','team_size','source_code','project_url']);
        $this->dispatchBrowserEvent('addUpdateModal');
    }

    public function submit() 
    {
        $param = $this->validate();
        if($param['image'] == null){
            unset($param['image']);
        }
        $user_id = auth()->user()->id;
        $param['user_id'] = $user_id;
        $project = Project::where('id',$param['recordId'])->first();
        $param = (object) $param;
        if($project){
            if(isset($param->image) && $param->image != null){
                $img = basename($project->image);
                $param->image = $this->image->storeAs('projects/image',$img ,'userPublic');
            }
            $project->update((array) $param);
        }else{
            if($param->image != null){
                $param->image = $this->image->store('projects/image' ,'userPublic');
            }
            $project = Project::create((array)$param);
        }
        $res = $param->recordId != 0 ? success('Project Updated successfully.') : success('Project added successfully.');
        $this->dispatchBrowserEvent('close-modal');
        $this->refreshData();
        $this->recordId = 0;
        $this->category_id = null;
        $this->categories = Category::getCategories();
        $this->reset(['technologies','description','start_date','image','end_date','category_id','slug','title','team_size','source_code','project_url']);
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
