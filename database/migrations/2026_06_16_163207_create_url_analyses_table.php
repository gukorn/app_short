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
        Schema::create('url_analyses', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('urlshort_id')->nullable()->comment('urlshort_id');
            $table->date('number_date');
            $table->integer('number_view')->default(0);
            $table->integer('number_review')->default(0);

            $table->dateTime('created_at', 3);
            $table->bigInteger('created_by');
            $table->dateTime('updated_at', 3);
            $table->bigInteger('updated_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('url_analyses');
    }
};
