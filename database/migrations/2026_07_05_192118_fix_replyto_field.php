<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guestbook_entries', function (Blueprint $table) {
            $table->boolean('is_reply')
                ->default(false)
                ->index();

            $table->foreignUuid('parent_entry_id')
                ->nullable()
                ->constrained('guestbook_entries')
                ->nullOnDelete()
                ->index();
        });

        Schema::table('guestbook_entries', function (Blueprint $table) {
            $table->dropForeign(['reply_to']);
            $table->dropColumn('reply_to');
        });
    }

    public function down(): void
    {
        Schema::table('guestbook_entries', function (Blueprint $table) {
            $table->foreignUuid('reply_to')
                ->nullable()
                ->after('guestbook_id')
                ->constrained('guestbook_entries')
                ->nullOnDelete()
                ->cascadeOnUpdate();
        });

        Schema::table('guestbook_entries', function (Blueprint $table) {
            $table->dropForeign(['parent_entry_id']);
            $table->dropColumn([
                'is_reply',
                'parent_entry_id',
            ]);
        });
    }
};