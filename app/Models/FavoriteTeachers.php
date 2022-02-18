<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
//use Illuminate\Database\Eloquent\SoftDeletes;

class FavoriteTeachers extends Model
{
    //use SoftDeletes;
    use Notifiable;
    
    protected $table = "favorite_teachers";
}

?>