<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaryawanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karyawan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('divisi_id')->constrained('divisi');
            $table->foreignId('jabatan_id')->constrained('jabatan');
            $table->foreignId('status_karyawan_id')->constrained('status_karyawan');
            $table->foreignId('lokasi_id')->constrained('lokasi');
            $table->string('nama', 100);
            $table->string('email', 50);
            $table->string('nik', 30);
            $table->text('alamat');
            $table->integer('gaji_pokok');
            $table->date('tgl_masuk');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->enum('status_kawin', ['Menikah', 'Belum Menikah']);
            $table->enum('status_keaktifan', ['Masih Bekerja', 'Habis Kontrak']);
            $table->string('foto', 200);
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
        Schema::dropIfExists('karyawans');
    }
}
