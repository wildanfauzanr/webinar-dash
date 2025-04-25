<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebinarsTable extends Migration
{
    public function up()
    {
        Schema::create('webinars', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->date('date');
            $table->time('time');
            $table->foreignId('recruiter_id')->constrained('users');
            $table->timestamps();
        });

        Schema::create('webinar_applicant', function (Blueprint $table) {
            $table->id();
            $table->foreignId('webinar_id')->constrained('webinars')->onDelete('cascade');
            $table->foreignId('applicant_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('webinar_applicant');
        Schema::dropIfExists('webinars');
    }
}
