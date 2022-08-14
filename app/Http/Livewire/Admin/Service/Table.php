<?php

namespace App\Http\Livewire\Admin\Service;

use App\Models\Service;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class Table extends DataTableComponent
{
 
    public $name;
    public $curPage = 'Services';
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
            Column::make('Created_at')
                ->sortable(),
            Column::make('Status')
                ->sortable()
                ->format(function($value, $column, $row) {
                    $statusActive = $value == 1 ? 'checked' : '';
                    return '<label class="custom-switch m-0 m-pointer">
                        <input  wire:click="updateStatus('.$row->id.','.$value.')" type="checkbox" value="1" class="custom-switch-input" '.$statusActive.'>
                        <span class="custom-switch-indicator"></span></label>';
                })
                ->asHtml(),
            Column::make('Action')
                ->format(function($value, $column, $row) {
                    $row = (object)['id' => $row->id];
                    $action = ['show','edit','delete'];
                    $component = "admin.service.services";
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
        $Service = Service::where('id',$id)->first();
        $image_path = public_path('uploads/'.$Service->getAttributes()['image']);
        if($Service == null){
            $res = error('Service not found.');
        }else{
            if(\File::exists($image_path)) {
                \File::delete($image_path);
            }
            $res = success('Service deleted successfully.');
            $Service->delete();
        }
        $this->dispatchBrowserEvent('alert',$res);
    }

    public function deleteSelected()
    { 
        $res = error('Please select row');
        if ($this->selectedRowsQuery->count() > 0) {
            $Services = Service::whereIn('id',$this->selectedKeys)->get();
            foreach($Services as $row){
                $image_path = public_path('uploads/'.$row->getAttributes()['image']);
                if(\File::exists($image_path)) {
                    \File::delete($image_path);
                }
                $row->delete();
            }
            $res = success('Services deleted successfully.');
        }
        $this->dispatchBrowserEvent('alert',$res);
    }

    public function updateStatus($id)
    {
        $Service = Service::where('id',$id)->first();
        $Service->update(['status' => !$Service->status]);
        $res = success('Service status changed successfully.');
        $this->dispatchBrowserEvent('alert',$res);
    }


    public function query():Builder
    {
        return Service::select('*')
        ->latest();
    }

    public function refresh()
    {
        $this->emit('refreshDatatable');
    }

}
