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
        Schema::create('prospects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('name');
            $table->integer('age');
            $table->string('occupation');
            $table->integer('category');
            $table->integer('source');
            $table->integer('relationship');
            $table->integer('status');
            $table->text('remarks')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prospects', function (Blueprint $table) {
            // Dropping the foreign key constraint first
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('prospects');
    }
};
