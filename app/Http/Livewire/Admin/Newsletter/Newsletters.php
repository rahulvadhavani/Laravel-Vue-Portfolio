<?php

namespace App\Http\Livewire\Admin\Newsletter;

use App\Models\Newsletter as ModelsNewsletter;
use Livewire\Component;


class Newsletters extends Component
{
    public $page = 'Newsletter';
    public function render()
    {
        return view('livewire.admin.newsletter.index');
    }

    public $curPage = 'Newsletter';
    public function refreshData()
    {
        $this->emit('refresh');
    }

}
