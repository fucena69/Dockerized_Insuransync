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
        Schema::table('profiles', function (Blueprint $table) {
            // Add fullname column
            $table->string('fullname')->nullable()->after('user_id');

            // Add unique constraint to user_id column
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            // Drop columns and constraints if migration is rolled back
           // $table->dropColumn('fullname');
           // $table->dropUnique('profiles_user_id_unique');
        });
    }
};
