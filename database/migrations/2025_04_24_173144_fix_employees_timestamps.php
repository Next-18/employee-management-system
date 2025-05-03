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
        // Check if the table exists first
        if (Schema::hasTable('employees')) {
            // Add created_at if it doesn't exist
            if (!Schema::hasColumn('employees', 'created_at')) {
                Schema::table('employees', function (Blueprint $table) {
                    $table->timestamp('created_at')->nullable()->useCurrent();
                });
            }

            // Add updated_at if it doesn't exist
            if (!Schema::hasColumn('employees', 'updated_at')) {
                Schema::table('employees', function (Blueprint $table) {
                    $table->timestamp('updated_at')->nullable()->useCurrent()->useCurrentOnUpdate();
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Only remove columns if they exist
        if (Schema::hasTable('employees')) {
            Schema::table('employees', function (Blueprint $table) {
                // Check before dropping each column
                if (Schema::hasColumn('employees', 'created_at')) {
                    $table->dropColumn('created_at');
                }
                
                if (Schema::hasColumn('employees', 'updated_at')) {
                    $table->dropColumn('updated_at');
                }
            });
        }
    }
};