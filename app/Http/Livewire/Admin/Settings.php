<?php

namespace App\Http\Livewire\Admin;

use App\Models\Setting;
use Illuminate\Validation\ValidationData;
use Livewire\Component;
use Livewire\WithFileUploads;


class Settings extends Component
{
    use WithFileUploads;

    public $page = 'Settings';
    public $url_secret,$support_email,$contact,$address,$instagram,$linkedin ,$twitter,$facebook,$devloper_name,
    $resume_url,$user_image_url,$user_image,$logo_image,$logo_image_url,$profession,$about = "";

    protected $rules = [
        'url_secret' => 'required',
        'support_email' => 'required|email|max:100',
        'contact' => 'nullable|min:10|max:15',
        'address' => 'nullable',
        'instagram' => 'nullable|url',
        'twitter' => 'nullable|url',
        'linkedin' => 'nullable|url',
        'facebook' => 'nullable|url',
        'user_image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        'logo_image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        'resume_url' => 'required|url',
        'devloper_name' => 'required|max:190',
        'profession' => 'required',
        'about' => 'required',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
 

    public function submit() {
        $validatedData = $this->validate();
        foreach($validatedData as $key => $value){
            if($value != ''){
                if($key == 'user_image' && !empty($validatedData['user_image'])){
                    $value = $this->user_image->store('home/user_image', 'userPublic');
                }
                if($key == 'logo_image' && !empty($validatedData['logo_image'])){
                    $value = $this->logo_image->store('home/logo_image', 'userPublic');
                }
                Setting::updateOrCreate(['key' => $key],['key' => $key, 'value' => $value]);
            }
        }
        $res = success('Settings Updated successfully.');
        $this->dispatchBrowserEvent('alert',$res);
    }

    public function mount()
    {
        $Settings = Setting::where('status',1)->get()->pluck('value','key')->toArray();
        $this->support_email = $Settings['support_email'] ?? "";
        $this->url_secret = $Settings['url_secret'] ?? "";
        $this->contact = $Settings['contact'] ?? "";
        $this->address = $Settings['address'] ?? "";
        $this->linkedin = $Settings['linkedin'] ?? "";
        $this->twitter = $Settings['twitter'] ?? "";
        $this->instagram = $Settings['instagram'] ?? "";
        $this->facebook = $Settings['facebook'] ?? "";
        $this->devloper_name = $Settings['devloper_name'] ?? "";
        $this->resume_url = $Settings['resume_url'] ?? "";
        $this->user_image_url = (isset($Settings['user_image']) && $Settings['user_image'] != "") ? asset('uploads/'.$Settings['user_image']) : "";
        $this->logo_image_url = (isset($Settings['logo_image']) && $Settings['logo_image'] != "") ? asset('uploads/'.$Settings['logo_image']) : "";
        $this->profession = $Settings['profession']?? "";
        $this->about = $Settings['about']?? "";

    }

    public function render()
    {
        return view('livewire.admin.settings');
    }
}
