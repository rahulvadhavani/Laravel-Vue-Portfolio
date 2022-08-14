<?php

namespace App\Http\Livewire\Admin\Project;
use App\Models\Category;
use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class Table extends DataTableComponent
{
 
    public $name,$categories,$category_id;
    public $curPage = 'Projects';
    public $recordId = 0;
    public bool $responsive = true;
    protected $listeners = ['deleteRecrod','refresh'];
    public array $bulkActions = [
        'deleteSelected' => 'Delete',
    ];
    public bool $singleColumnSorting = true; 
   
    public function columns(): array
    {
        return [
            Column::make('Title')
                ->sortable()
                ->searchable(),
            Column::make('Slug')
                ->sortable()
                ->searchable(),
            Column::make('Category','category.name')
            ->searchable()
            ->sortable(function(Builder $query, $direction) {
                return $query->orderBy(Category::select('name')->whereColumn('projects.category_id', 'categories.id'), $direction);
            }),
            Column::make('Created_at')
                ->sortable(),
            Column::make('Status')
                ->sortable()
                ->format(function($value, $column, $row) {
                    $rowData = '<select name="status" class="form-control show-tick"  wire:change="updateStatus('.$row->id.',$event.target.value)">';
                    foreach(Project::STATUSARR as $key => $option){
                        $selected = $key == $value ? 'selected' : "";
                        $rowData.= '<option '.$selected.' value="'.$key.'">'.$option.'</option>';
                    }
                    $rowData.= '</select>';
                    return $rowData;

                })
                ->asHtml(),
            Column::make('Action')
                ->format(function($value, $column, $row) {
                    $row = (object)['id' => $row->id];
                    $action = ['show','edit','delete'];
                    $component = "admin.project.projects";
                    return view('livewire.admin.common.actions',compact('row','action','component'));
                }),
        ];
    }
   
    public function delete($id)
    {
        $this->dispatchBrowserEvent('viewDelete',['id' => $id]);
    }

    public function deleteRecrod($id)
    {
        $Project = Project::where('id',$id)->first();
        if($Project == null){
            $res = error('Project not found.');
        }else{
            $res = success('Project deleted successfully.');
            $Project->delete();
        }
        $this->dispatchBrowserEvent('alert',$res);
    }

    public function deleteSelected()
    {
        $res = error('Please select row');
        if ($this->selectedRowsQuery->count() > 0) {
            $this->selectedRowsQuery->delete();
            $res = success('Projects deleted successfully.');
        }
        $this->dispatchBrowserEvent('alert',$res);
    }

    public function updateStatus($id,$status="")
    {
        $Project = Project::where('id',$id)->first();
        $Project->update(['status' => $status]);
        $res = success('Project status changed successfully.');
        $this->dispatchBrowserEvent('alert',$res);
    }

    public function query():Builder
    {
        return Project::with([
        'category' => function($query){
            $query->select('id','name');
        },
        ])
        ->select('*')
        ->latest();

    }

    public function refresh()
    {
        $this->emit('refreshDatatable');
    }

}
