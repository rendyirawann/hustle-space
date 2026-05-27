<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PublishedPhoto extends Model
{
    protected $fillable = ['user_id', 'image_path', 'ip_address'];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
