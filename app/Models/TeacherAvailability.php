<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

//use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherAvailability extends Model
{
    //use SoftDeletes;
    use Notifiable;
    
    protected $table = "teacher_availability";
}

?>