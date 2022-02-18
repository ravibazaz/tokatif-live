<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
//use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdminWalletLog extends Model
{
    use SoftDeletes;
    use Notifiable;
    
    protected $table = "admin_wallet_log";
}

?>