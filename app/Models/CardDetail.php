<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;

class CardDetail extends Model
{
    use SoftDeletes;
    use Notifiable;
    
    protected $table = "user_card_detail";
}

?>