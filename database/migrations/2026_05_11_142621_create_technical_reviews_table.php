<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('technical_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permit_id')->constrained('permits')->onDelete('cascade');
            $table->foreignId('reviewed_by')->constrained('users')->onDelete('cascade');
            $table->boolean('conformite');
            $table->text('remarque')->nullable();
            $table->dateTime('reviewed_at');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('technical_reviews'); }
};