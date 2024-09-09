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
        Schema::create('tamu', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('gambar', 50)->nullable();
            $table->string('nama_tamu');
            $table->string('jenis_kelamin')->nullable();
            $table->string('asal');
            $table->string('nohp');
            $table->string('tujuan', 100);
            $table->string('keterangan', 100);
            $table->timestamp('tanggal')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tamu');
    }
};
