<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add column without unique constraint first
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('registration_token')->nullable()->after('user_id');
        });

        // Generate tokens for existing registrations
        DB::table('registrations')->whereNull('registration_token')->get()->each(function ($registration) {
            DB::table('registrations')
                ->where('id', $registration->id)
                ->update(['registration_token' => \Illuminate\Support\Str::random(32)]);
        });

        // Now add unique constraint
        Schema::table('registrations', function (Blueprint $table) {
            $table->string('registration_token')->nullable(false)->change();
            $table->unique('registration_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registrations', function (Blueprint $table) {
            $table->dropColumn('registration_token');
        });
    }
};
