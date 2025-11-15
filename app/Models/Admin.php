<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $table = 'users';

    protected $primaryKey = 'id_user';   
    public $incrementing = true;         
    protected $keyType = 'int';  

    protected $fillable = [
        'username',
        'password',
        'role',
        'is_active'
    ];

    protected $hidden = ['password'];
}
