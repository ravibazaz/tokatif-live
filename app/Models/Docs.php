<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Docs extends Model
{
    protected $table="docs";
    protected $hidden=['created_at','updated_at'];
}
