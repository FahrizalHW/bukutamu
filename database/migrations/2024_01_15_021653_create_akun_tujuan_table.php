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
        Schema::create('akun_tujuan', function (Blueprint $table) {
            $table->integer('id_akun', true);
            $table->string('email', 100);
            $table->string('password', 50);
            $table->string('nama', 100);
            $table->string('jabatan', 50);
            $table->string('no_hp', 13);
            $table->string('photo', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('akun_tujuan');
    }
};
