<?php

namespace App\Http\Livewire\Admin\Contact;

use App\Models\ContactUs;
use Livewire\Component;


class ContactRequests extends Component
{
    public $page = 'Contact-Request';
    public function render()
    {
        return view('livewire.admin.contact.index');
    }

    public $subject,$message,$name,$email = "";

    public $curPage = 'Contact-Request';
    public $recordId = 0;
    protected $listeners = ['view'];


    public function view($id)
    {
        $ContactUs = ContactUs::where('id',$id)
        ->first();
        if($ContactUs == null){
            $this->dispatchBrowserEvent('alert',error('Record not found'));
            return;
        }
        $this->modalData = $ContactUs;
        $this->modalStatus = $ContactUs->status;
        $this->dispatchBrowserEvent('viewModal');
    }


    public function refreshData()
    {
        $this->emit('refresh');
    }

}
