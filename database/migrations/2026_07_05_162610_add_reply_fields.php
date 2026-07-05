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
            $table->boolean('is_reply')
                ->default(false)
                ->index();

            $table->foreignId('parent_entry_id')
                ->nullable()
                ->constrained('guestbook_entries')
                ->nullOnDelete()
                ->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('guestbook_entries', function (Blueprint $table) {
            $table->dropForeign(['parent_entry_id']);
            $table->dropColumn([
                'is_reply',
                'parent_entry_id',
            ]);
        });
    }
};