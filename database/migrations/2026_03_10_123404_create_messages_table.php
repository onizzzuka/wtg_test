<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('message');
            $table->foreignIdFor(User::class, 'sender')->constrained('users', 'id')->onDelete('cascade');
            $table->foreignIdFor(User::class, 'recipient')->constrained('users', 'id')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('messages');
    }
};
