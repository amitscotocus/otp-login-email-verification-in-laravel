<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Verifytoken extends Model
{
    protected $fillable = ['token', 'email', 'is_activated'];
}
