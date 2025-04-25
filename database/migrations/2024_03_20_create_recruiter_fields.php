<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'is_recruiter')) {
                $table->boolean('is_recruiter')->default(false);
            }
            if (!Schema::hasColumn('users', 'company_name')) {
                $table->string('company_name')->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_recruiter', 'company_name']);
        });
    }
}; 