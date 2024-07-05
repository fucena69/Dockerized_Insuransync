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
        Schema::create('client_categories', function (Blueprint $table) {
            $table->id();
            $table->string('category');
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });

        Schema::create('client_sources', function (Blueprint $table) {
            $table->id();
            $table->string('source');
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });

        Schema::create('client_relationships', function (Blueprint $table) {
            $table->id();
            $table->string('relationship');
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
        Schema::create('client_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_categories');
        Schema::dropIfExists('client_sources');
        Schema::dropIfExists('client_relationships');
        Schema::dropIfExists('client_statuses');
    }
};
