<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('business_analytics', function (Blueprint $table) {
        $table->id();
        $table->foreignId('business_profile_id')->constrained()->onDelete('cascade');
        $table->date('date');
        $table->integer('views')->default(0);
        $table->integer('searches')->default(0);
        $table->integer('calls')->default(0);
        $table->integer('direction_requests')->default(0);
        $table->json('additional_metrics')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_analytics');
    }
};
