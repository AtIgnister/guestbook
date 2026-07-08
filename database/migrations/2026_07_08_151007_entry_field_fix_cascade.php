<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guestbook_entries', function (Blueprint $table) {
            $table->dropConstrainedForeignId('parent_entry_id');
        });

        Schema::table('guestbook_entries', function (Blueprint $table) {
            $table->foreignUuid('parent_entry_id')
                ->nullable()
                ->constrained('guestbook_entries')
                ->cascadeOnDelete()
                ->index();
        });
    }

    public function down(): void
    {
        Schema::table('guestbook_entries', function (Blueprint $table) {
            $table->dropForeign(['parent_entry_id']);

            $table->foreign('parent_entry_id')
                ->references('id')
                ->on('guestbook_entries')
                ->nullOnDelete();
        });
    }
};