<?php

use App\Models\GuestbookEntries;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('guestbook_entry_ips', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignId('guestbook_entries_id')->references('id')->on('guestbook_entries')
            ->cascadeOnDelete()->cascadeOnUpdate();

            // SHA-256 HMAC stored as binary (32 bytes)
            $table->binary('ip_hash', 32);

            $table->timestamps();
            $table->index('ip_hash');

            $table->unique([
                'guestbook_entries_id',
                'ip_hash',
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guestbook_entry_ips');
    }
};
