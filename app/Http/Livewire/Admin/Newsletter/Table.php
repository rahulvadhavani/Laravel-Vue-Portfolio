<?php

namespace App\Http\Livewire\Admin\Newsletter;

use App\Models\Newsletter;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

class Table extends DataTableComponent
{
 
    public $name;
    public $curPage = 'Newsletter';
    public bool $responsive = true;
    protected $listeners = ['deleteRecrod','refresh'];
    public array $bulkActions = [
        'deleteSelected' => 'Delete',
    ];
    public bool $singleColumnSorting = true; 
   
    public function columns(): array
    {
        return [
            Column::make('email')
                ->sortable()
                ->searchable(),
            Column::make('Created_at')
                ->sortable()
                ->searchable(),
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
                    $action = ['delete'];
                    $component = "admin.newsletter.newsletters";
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
        $newsLetter = Newsletter::where('id',$id)->first();
        if($newsLetter == null){
            $res = error('Record not found.');
        }else{
            $res = success('Record deleted successfully.');
            $newsLetter->delete();
        }
        $this->dispatchBrowserEvent('alert',$res);
    }

    public function deleteSelected()
    { 
        $res = error('Please select row');
        if ($this->selectedRowsQuery->count() > 0) {
            $newsLetter  = Newsletter::whereIn('id',$this->selectedKeys)->delete();
            $res = success('Records deleted successfully.');
        }
        $this->dispatchBrowserEvent('alert',$res);
    }

    public function updateStatus($id)
    {
        $newsLetter = Newsletter::where('id',$id)->first();
        $newsLetter->update(['status' => !$newsLetter->status]);
        $res = success('Record status changed successfully.');
        $this->dispatchBrowserEvent('alert',$res);
    }


    public function query():Builder
    {
        return Newsletter::select('*')
        ->latest();
    }
    
    public function refresh()
    {
        $this->emit('refreshDatatable');
    }

}
