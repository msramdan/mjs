<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatusRequestFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('status_request_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('request_form_id')->constrained('request_forms')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users');
            $table->integer('step');
            $table->enum('status', ['Waiting', 'Approve']);
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
        Schema::dropIfExists('status_request_forms');
    }
}
