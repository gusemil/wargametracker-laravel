<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Playgroup extends Model
{
    protected $table = "playgroups"; //Determine which DB table we we will look for

    protected $fillable = 
    [
    'name',
    ];
}
