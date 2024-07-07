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
        Schema::table('prospects', function (Blueprint $table) {
            $table->date('approach_date')->nullable();
            $table->timestamp('meeting_date')->nullable();
            $table->timestamp('followup_date')->nullable();
            $table->timestamp('processing_date')->nullable();   
            $table->date('submitted_date')->nullable();
            $table->date('approved_date')->nullable();
            $table->date('denied_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prospects', function (Blueprint $table) {
            $table->dropColumn('approach_date');
            $table->dropColumn('meeting_date');
            $table->dropColumn('followup_date');
            $table->dropColumn('processing_date');
            $table->dropColumn('submitted_date');
            $table->dropColumn('approved_date');
            $table->dropColumn('denied_date');
        });
    }
};
