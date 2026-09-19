<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement(
                'ALTER TABLE tamu MODIFY keterangan VARCHAR(255) NULL, '
                . 'MODIFY tanggal TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP'
            );
        }

        Schema::table('tamu', function (Blueprint $table) {
            $table->index('tanggal');
            $table->index('nama_tamu');
            $table->index('asal');
        });
    }

    public function down(): void
    {
        Schema::table('tamu', function (Blueprint $table) {
            $table->dropIndex(['tanggal']);
            $table->dropIndex(['nama_tamu']);
            $table->dropIndex(['asal']);
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement(
                'ALTER TABLE tamu MODIFY keterangan VARCHAR(100) NULL, '
                . 'MODIFY tanggal TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'
            );
        }
    }
};
