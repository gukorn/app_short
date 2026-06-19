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
        Schema::create('log_errors', function (Blueprint $table) {
            $table->id()->comment('เลขที่ตาราง');

            $table->string('path_info', 200)->comment('path ที่ error');
            $table->string('method', 10)->comment('Method');
            $table->string('code', 20)->comment('code');
            $table->text('message')->comment('message');
            $table->integer('line')->comment('line code error');

            $table->dateTime('created_at', 3)->comment('วันที่สร้าง');
            $table->bigInteger('created_by')->nullable()->comment('สร้างโดย');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_errors');
    }
};
