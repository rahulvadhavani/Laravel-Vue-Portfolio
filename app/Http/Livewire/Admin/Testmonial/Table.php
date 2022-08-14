<?php

namespace App\Http\Livewire\Admin\Testmonial;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class Table extends DataTableComponent
{
 
    public $name;
    public $curPage = 'Testimonial';
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
            Column::make('name')
                ->sortable()
                ->searchable(),
            Column::make('business')
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
                    $component = "admin.testmonial.testmonials";
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
        $Testimonial = Testimonial::where('id',$id)->first();
        $image_path = public_path('uploads/'.$Testimonial->getAttributes()['image']);
        if($Testimonial == null){
            $res = error('Testimonial not found.');
        }else{
            if(\File::exists($image_path)) {
                \File::delete($image_path);
            }
            $res = success('Testimonial deleted successfully.');
            $Testimonial->delete();
        }
        $this->dispatchBrowserEvent('alert',$res);
    }

    public function deleteSelected()
    { 
        $res = error('Please select row');
        if ($this->selectedRowsQuery->count() > 0) {
            $Testimonial = Testimonial::whereIn('id',$this->selectedKeys)->get();
            foreach($Testimonial as $row){
                $image_path = public_path('uploads/'.$row->getAttributes()['image']);
                if(\File::exists($image_path)) {
                    \File::delete($image_path);
                }
                $row->delete();
            }
            $res = success('Testimonial deleted successfully.');
        }
        $this->dispatchBrowserEvent('alert',$res);
    }

    public function updateStatus($id)
    {
        $Testimonial = Testimonial::where('id',$id)->first();
        $Testimonial->update(['status' => !$Testimonial->status]);
        $res = success('Testimonial status changed successfully.');
        $this->dispatchBrowserEvent('alert',$res);
    }


    public function query():Builder
    {
        return Testimonial::select('*')
        ->latest();
    }

    public function refresh()
    {
        $this->emit('refreshDatatable');
    }

}
