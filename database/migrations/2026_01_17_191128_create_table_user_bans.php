<?php

use App\Models\User;
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
        Schema::create('table_user_bans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id') // the user being banned
                ->constrained('users')
                ->cascadeOnDelete();
            $table->foreignId('banned_by') // the admin who banned
                ->constrained('users')
                ->cascadeOnDelete();
            $table->timestamps();

            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_user_bans');
    }
};
