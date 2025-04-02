<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $table = "games"; //Determine which DB table we we will look for

    protected $fillable = 
    [
    'name',
    ];
}
