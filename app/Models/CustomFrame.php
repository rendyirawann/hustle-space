<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomFrame extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'layout',
        'base_theme',
        'decorations',
        'is_public'
    ];

    protected $casts = [
        'decorations' => 'array',
        'is_public' => 'boolean',
        'layout' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
