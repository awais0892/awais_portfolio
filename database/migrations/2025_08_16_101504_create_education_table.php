<?php
// database/migrations/xxxx_create_education_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationTable extends Migration
{
    public function up()
    {
        Schema::create('education', function (Blueprint $table) {
            $table->id();
            $table->string('degree');
            $table->string('institution');
            $table->string('location')->nullable();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->string('grade')->nullable();
            $table->text('description')->nullable();
            $table->json('achievements')->nullable();
            $table->string('type')->default('degree'); // degree, certification, training
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('education');
    }
}