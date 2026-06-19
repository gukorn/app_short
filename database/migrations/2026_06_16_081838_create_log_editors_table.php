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
        Schema::create('log_editors', function (Blueprint $table) {
            $table->id()->comment('เลขที่ตาราง');
            $table->string('table_name', 50)->comment('ตาราง');
            $table->bigInteger('table_id')->comment('เลขที่ตาราง');
            $table->json('json_log')->comment('การแก้');
            $table->string('msg')->nullable()->comment('ข้อความ');

            $table->dateTime('created_at', 3)->comment('วันที่สร้าง');
            $table->bigInteger('created_by')->nullable()->comment('สร้างโดย');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_editors');
    }
};
