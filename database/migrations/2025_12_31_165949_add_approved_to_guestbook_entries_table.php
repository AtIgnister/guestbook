<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('guestbook_entries', function (Blueprint $table) {
            $table->boolean('approved')->default(true)->after('comment');
        });
    }

    public function down(): void
    {
        Schema::table('guestbook_entries', function (Blueprint $table) {
            $table->dropColumn('approved');
        });
    }
};
