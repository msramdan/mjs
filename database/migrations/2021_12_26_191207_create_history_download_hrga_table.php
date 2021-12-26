<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryDownloadHrgaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_download_hrga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dokumen_hrga_id')->constrained('dokumen_hrga');
            $table->foreignId('user_id')->constrained('users');
            $table->string('language', 30);
            $table->string('device', 30);
            $table->string('os', 30);
            $table->string('browser', 30);
            $table->string('robot', 10);
            $table->string('ip', 20);
            $table->text('header');
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
        Schema::dropIfExists('history_download_hrgas');
    }
}
