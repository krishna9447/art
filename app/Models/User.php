<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    //users
    //php trait
    use Notifiable;

    protected $fillable = array(
        'name',
        'email',
        'password',
        'email_token'
    );

}
