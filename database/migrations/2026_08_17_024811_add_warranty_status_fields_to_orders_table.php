<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('warranty_status')->nullable()->after('warranty_claimed_at');
            $table->text('warranty_response')->nullable()->after('warranty_status');
            $table->timestamp('warranty_responded_at')->nullable()->after('warranty_response');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['warranty_status', 'warranty_response', 'warranty_responded_at']);
        });
    }
};
