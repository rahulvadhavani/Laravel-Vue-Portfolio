<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'business',
        'image',
        'status',
        'description',
    ];

    public function getImageAttribute($value){
        return app()->environment('local') ? url('uploads/'.$value) : url('public/uploads/'.$value);
    }

}
