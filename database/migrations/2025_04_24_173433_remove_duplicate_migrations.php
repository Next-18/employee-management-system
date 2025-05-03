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
        Schema::table('users', function (Blueprint $table) {
            // Only add password if it doesn't exist
            if (!Schema::hasColumn('users', 'password')) {
                $table->string('password')
                    ->after('email')
                    ->nullable(false);
            }

            // Check if unique constraint exists before adding
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexes = $sm->listTableIndexes('users');
            
            if (!array_key_exists('users_email_unique', $indexes)) {
                $table->string('email')->unique()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Only drop if exists
            if (Schema::hasColumn('users', 'password')) {
                $table->dropColumn('password');
            }
            
            // Don't drop the email unique constraint as it likely existed before
        });
    }
};