<?php

namespace App\Http\Livewire\Admin;

use App\Models\Blog;
use App\Models\ContactUs;
use App\Models\Newsletter;
use App\Models\Service;
use App\Models\Skill;
use Livewire\Component;

class Dashboard extends Component
{
    public $page = 'dashboard';
    public $cards = [];

    public function mount(){
        $data =[];
        $data['Blogs'] = ['count' => Blog::count(),'route' => route('blogs')];
        $data['Skils'] = ['count' => Skill::count(),'route' => route('skills')];
        $data['Newsletters'] = ['count' => Newsletter::count(),'route' => route('newsletters')];
        $data['Contacts'] = ['count' => ContactUs::count(),'route' =>route('contact_requests')];
        $data['Services'] = ['count' => Service::count(),'route' =>route('services')];
        $this->cards = $data;
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
