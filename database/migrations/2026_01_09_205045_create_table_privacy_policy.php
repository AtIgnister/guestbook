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
        Schema::create('table_privacy_policy', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->timestamp("published_at")->nullable();
            $table->text('content');
            $table->text("change_summary");
            $table->boolean("visible")->default(true);
            $table->boolean("is_draft")->default(true);

            $table->index(['visible', 'is_draft']);
            $table->index('published_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_privacy_policy');
    }
};
