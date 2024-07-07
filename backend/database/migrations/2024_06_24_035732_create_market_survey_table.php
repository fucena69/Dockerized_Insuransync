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
        Schema::create('market_survey', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('saving_often');
            $table->string('savings_location');
            $table->string('critical_illness_level');
            $table->string('disabled_level');
            $table->string('force_retirement_level');
            $table->string('child_college_level');
            $table->string('money_protect');
            $table->timestamp('contact_date')->nullable();
            $table->text('questions')->nullable();
            $table->string('name');
            $table->string('gender');
            $table->integer('age');
            $table->string('phone_number');
            $table->string('civil_status');
            $table->string('occupation');
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
        Schema::table('market_survey', function (Blueprint $table) {
            // Dropping the foreign key constraint first
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('market_survey');
    }
};
