<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Domain\Notifications\Models\NotificationType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users_notifications', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->foreignIdFor(NotificationType::class);
            $table->text('content')->nullable();
            $table->dateTime('send_time')->nullable();
            $table->bigInteger('user_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_notifications');
    }
};
