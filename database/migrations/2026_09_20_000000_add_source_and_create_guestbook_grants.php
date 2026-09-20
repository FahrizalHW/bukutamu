<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tamu', function (Blueprint $table) {
            $table->string('sumber', 20)->default('kiosk')->after('keterangan')->index();
        });

        Schema::create('guestbook_grants', function (Blueprint $table) {
            $table->id();
            $table->char('token_hash', 64)->unique();
            $table->char('session_hash', 64)->index();
            $table->timestamp('expires_at')->index();
            $table->timestamp('used_at')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guestbook_grants');
        Schema::table('tamu', fn (Blueprint $table) => $table->dropColumn('sumber'));
    }
};
