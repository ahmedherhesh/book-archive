<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'cat_id',
        'sub_cat_id',
        'title',
        'description',
        'file',
        'date'
    ];
    function category()
    {
        return $this->belongsTo(Category::class, 'cat_id');
    }
    function subCategory()
    {
        return $this->belongsTo(Category::class, 'sub_cat_id');
    }
    function getFileAttribute($file)
    {
        return $this->attributes['file'] ? asset("uploads/files/{$this->cat_id}/$file") : null;
    }

    function setFileAttribute($file)
    {
        $file_name =  rand(1000, 9999) . time() . '.' . $file->extension();
        $file->move(public_path("uploads/files/{$this->cat_id}"), $file_name);
        $this->attributes['file'] = $file_name;
    }
}
