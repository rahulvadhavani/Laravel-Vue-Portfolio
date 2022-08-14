<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    const STATUSPENDING = 0;
    const STATUSUNDERWORKING = 1;
    const STATUSCOMPLATED = 2;
    const STATUSARR = [
        'Pending',
        'Working',
        'Complated',
    ];
    protected $fillable = ['category_id','title','slug','start_date','image','source_code',
    'status','created_at','end_date','team_size','description','technologies','project_url'];

    public function getImageAttribute($value){
        // return url('public/uploads/'.$value);
        return app()->environment('local') ? url('uploads/'.$value) : url('public/uploads/'.$value);
    }
    
    public function getCreatedAtAttribute($value) {
        return Carbon::parse($value)->format('d ,F Y');
    }
    public function Category(){
        return $this->hasOne(Category::class,'id','category_id');
    }
    public function setTechnologiesAttribute($value)
    {
        $this->attributes['technologies'] = json_encode(explode(',',$value));
    }
    public function getTechnologiesAttribute($value)
    {
        return json_decode($value,true);
    }
}
