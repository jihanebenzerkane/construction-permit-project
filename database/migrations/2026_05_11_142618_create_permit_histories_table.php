<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('permit_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permit_id')->constrained('permits')->onDelete('cascade');
            $table->foreignId('old_status_id')->nullable()->constrained('statuses')->nullOnDelete();
            $table->foreignId('new_status_id')->constrained('statuses')->onDelete('cascade');
            $table->foreignId('changed_by')->constrained('users')->onDelete('cascade');
            $table->text('commentaire')->nullable();
            $table->dateTime('changed_at');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('permit_histories'); }
};