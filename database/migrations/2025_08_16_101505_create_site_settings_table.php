<?php
// database/migrations/xxxx_create_site_settings_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text'); // text, textarea, image, json
            $table->string('group')->default('general');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('site_settings');
    }
}