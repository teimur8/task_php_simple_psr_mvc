<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'username', 'email', 'text', 'is_done'
    ];
    protected $casts = [
        'is_done' => 'boolean'
    ];
}
