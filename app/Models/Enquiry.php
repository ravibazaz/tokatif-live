<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Enquiry extends Model
{
    use Notifiable;
    
    protected $table = "enquiries";
    protected $fillable = ['name','email','enquiry'];
}
?>