<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';

    protected $fillable = [
        'title', 'description',  'attachment', 'created_by' , 'cover_image'
    ];

     // Automatically generate slug based on the title
     public function setTitleAttribute($value)
     {
         $this->attributes['title'] = $value;
         $this->attributes['slug'] = Str::slug($value);
     }
}
