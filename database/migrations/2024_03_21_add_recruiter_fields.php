<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom hanya jika belum ada
            if (!Schema::hasColumn('users', 'is_recruiter')) {
                $table->boolean('is_recruiter')->default(false);
            }
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_recruiter');
        });
    }
}; 