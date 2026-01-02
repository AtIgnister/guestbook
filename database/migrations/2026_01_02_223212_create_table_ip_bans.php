<?php

use App\Models\Guestbook;
use App\Models\GuestbookEntryIp;
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
        Schema::create('ip_bans', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignIdFor(GuestbookEntryIp::class)
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor(Guestbook::class)
                ->nullable()
                ->constrained()
                ->cascadeOnDelete();

            $table->boolean("is_global");
            $table->index(['is_global', 'guestbook_id']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ip_bans');
    }
};
