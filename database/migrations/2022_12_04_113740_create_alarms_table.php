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
        Schema::dropIfExists('alarm');
        Schema::create('alarm', function (Blueprint $table) {
            $table->id('id_alarm');
            $table->string('kode_alarm');
            $table->foreignId('id_user');
            $table->foreignId('id_obat');
            $table->string('dosis');
            $table->time('waktu');
            $table->integer('pengulangan')->default(0);
            $table->string('aturan_tambahan');
            $table->string('aturan');
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
        Schema::dropIfExists('alarms');
    }
};
