<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingCategoryRequestFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_category_request_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_request_id')->constrained('category_request')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users');
            $table->tinyInteger('step');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setting_category_request_forms');
    }
}
