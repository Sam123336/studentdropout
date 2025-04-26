<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('school')->nullable();
            $table->string('gender');
            $table->integer('age');
            $table->string('address')->nullable();
            $table->string('region')->nullable();
            $table->string('family_size')->nullable();
            $table->string('parental_status')->nullable();
            $table->integer('mother_education')->nullable();
            $table->integer('father_education')->nullable();
            $table->string('mother_job')->nullable();
            $table->string('father_job')->nullable();
            $table->string('reason_for_choosing_school')->nullable();
            $table->string('guardian')->nullable();
            $table->integer('travel_time')->nullable();
            $table->integer('study_time')->nullable();
            $table->integer('number_of_failures')->nullable();
            $table->string('school_support')->nullable();
            $table->string('family_support')->nullable();
            $table->string('extra_paid_class')->nullable();
            $table->string('extra_curricular_activities')->nullable();
            $table->string('attended_nursery')->nullable();
            $table->string('wants_higher_education')->nullable();
            $table->string('internet_access')->nullable();
            $table->string('in_relationship')->nullable();
            $table->integer('family_relationship')->nullable();
            $table->integer('free_time')->nullable();
            $table->integer('going_out')->nullable();
            $table->integer('weekend_alcohol_consumption')->nullable();
            $table->integer('weekday_alcohol_consumption')->nullable();
            $table->integer('health_status')->nullable();
            $table->integer('number_of_absences')->nullable();
            $table->integer('grade_1')->nullable();
            $table->integer('grade_2')->nullable();
            $table->integer('final_grade')->nullable();
            $table->decimal('grade_avg', 5, 2)->nullable();
            $table->boolean('dropout_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
