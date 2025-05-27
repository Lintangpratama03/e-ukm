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
        //
        Schema::table('tb_dokumentasi', function (Blueprint $table) {
            $table->tinyInteger('status')->default(0)->after('deskripsi')->comment('0=pending, 1=validated');
            $table->unsignedBigInteger('validated_by')->nullable()->after('status');
            $table->timestamp('validated_at')->nullable()->after('validated_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('tb_dokumentasi', function (Blueprint $table) {
            $table->dropForeign(['validated_by']);
            $table->dropColumn(['status', 'validated_by', 'validated_at']);
        });
    }
};
