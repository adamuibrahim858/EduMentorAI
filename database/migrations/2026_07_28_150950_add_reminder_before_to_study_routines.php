<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('study_routines', function (Blueprint $table) {
            $table->unsignedSmallInteger('reminder_before')
                ->default(15)
                ->after('repeat_type')
                ->comment('Minutes before session to send reminder.');
        });
    }

    public function down(): void
    {
        Schema::table('study_routines', function (Blueprint $table) {
            $table->dropColumn('reminder_before');
        });
    }
};
