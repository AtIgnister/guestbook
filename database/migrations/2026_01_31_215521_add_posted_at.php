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
            $table->timestamp('posted_at')->nullable()->after('created_at')->index();
        });

        // Backfill posted_at with the existing created_at values
        DB::table('guestbook_entries')->update([
            'posted_at' => DB::raw('created_at'),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guestbook_entries', function (Blueprint $table) {
            $table->dropColumn('posted_at');
        });
    }
};
