<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('jadwal');
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id('id_jadwal');
            $table->foreignId('id_user');
            $table->string('nama_dokter');
            $table->date('waktu_check');
            $table->time('waktu');
            $table->time('waktu_pengingat');
            $table->integer('pengulangan')->default(0);
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
        Schema::dropIfExists('jadwals');
    }
};
