<?php

namespace Rougin\Windstorm\Fixture;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    protected $connection = 'default';

    protected $fillable = array('name');

    protected $hidden = array('password');

    protected $table = 'users';
}
