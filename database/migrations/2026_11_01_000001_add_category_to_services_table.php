<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('category')->default('smartphone')->after('name');
        });

        DB::table('services')
            ->where('name', 'like', '%Laptop%')
            ->orWhere('name', 'like', '%PC%')
            ->update(['category' => 'laptop']);
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }
};
