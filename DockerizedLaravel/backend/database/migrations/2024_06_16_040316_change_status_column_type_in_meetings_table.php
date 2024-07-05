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
        Schema::table('meetings', function (Blueprint $table) {
            // Drop the existing status column
            $table->dropColumn('status');
        });

        Schema::table('meetings', function (Blueprint $table) {
            // Add the new status column with integer type and default value 0
            $table->integer('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('meetings', function (Blueprint $table) {
            // Drop the new status column
            $table->dropColumn('status');
        });

        Schema::table('meetings', function (Blueprint $table) {
            // Recreate the original status column with string type and nullable
            $table->string('status')->nullable();
        });
    }
};
