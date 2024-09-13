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
        Schema::dropIfExists('obat');
        Schema::create('obat', function (Blueprint $table) {
            $table->id('id_obat');
            $table->string('nama_obat');
            $table->string('bentuk_obat');
            $table->date('kedaluwarsa');
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
        Schema::dropIfExists('obats');
    }
};
