<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


use Illuminate\Database\Eloquent\Factories\HasFactory;


class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'school', 'gender', 'age', 'address', 'family_size', 'parental_status',
        'mother_education', 'father_education', 'mother_job', 'father_job',
        'reason_for_choosing_school', 'guardian', 'travel_time', 'study_time',
        'number_of_failures', 'school_support', 'family_support', 'extra_paid_class',
        'extra_curricular_activities', 'attended_nursery', 'wants_higher_education',
        'internet_access', 'in_relationship', 'family_relationship', 'free_time',
        'going_out', 'weekend_alcohol_consumption', 'weekday_alcohol_consumption',
        'health_status', 'number_of_absences', 'grade_1', 'grade_2', 'final_grade',
        'dropped_out', 'region', 'dropout_status', 'grade_avg'
    ];
}
