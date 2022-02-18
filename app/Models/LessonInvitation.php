<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;

class LessonInvitation extends Model
{
    use SoftDeletes;
    use Notifiable;
    
    protected $table = "lesson_invitation"; 
}
