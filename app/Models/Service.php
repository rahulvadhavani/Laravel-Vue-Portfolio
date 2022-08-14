<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'description',
        'image',
        'slug',
        'title',
    ];

    public function getImageAttribute($value){
        return app()->environment('local') ? url('uploads/'.$value) : url('public/uploads/'.$value);
        // $image = file_exists(public_path('uploads/'.$val)) ?url('public/uploads/'.$val) : url('public/app_images/default.png');
    }
}
