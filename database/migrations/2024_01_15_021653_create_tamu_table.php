<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

  public function up() {
    Schema::create('tamu', function (Blueprint $table) {
      $table->id();
      $table->string('nama_tamu');
      $table->string('jenis_kelamin')->nullable();
      $table->string('nohp')->nullable();
      $table->string('asal')->nullable();
      $table->string('gambar', 50)->nullable();
      $table->string('tujuan', 100)->nullable();
      $table->string('keterangan', 100)->nullable();
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
