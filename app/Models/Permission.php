<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    public $table = 'permissions';

    public $fillable = [
        'name',
        'guard_name',
        'route', 
        'display',
        'group'
    ];
}
