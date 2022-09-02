<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentLesson extends Model
{
    protected $table = 'student_lessons';
    protected $fillable = ['booking_id', 'lesson_id','lesson_package_id', 'teacher_id', 'student_id','slots', 'booking_date','booking_time'];
}
