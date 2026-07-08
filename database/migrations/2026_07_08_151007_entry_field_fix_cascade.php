<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guestbook_entries', function (Blueprint $table) {
            $table->dropForeign(['parent_entry_id']);

            $table->foreign('parent_entry_id')
                ->references('id')
                ->on('guestbook_entries')
                ->cascadeOnDelete();
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