<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

//use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    //use SoftDeletes;
    use Notifiable;
    
    protected $table = "booking";
}

?>