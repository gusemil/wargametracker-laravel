<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlayedMatch extends Model
{
    protected $table = "matches"; //Determine which DB table we we will look for

    protected $fillable = 
    [
    'name',
    'description',
    'user_1_id',
    'user_2_id',
    'user_1_name',
    'user_2_name',
    'user_1_elo',
    'user_2_elo',
    'user_1_elo_change',
    'user_2_elo_change',
    'user_1_score',
    'user_2_score',
    'winner',
    'game',
    'playgroup'
    ];
}