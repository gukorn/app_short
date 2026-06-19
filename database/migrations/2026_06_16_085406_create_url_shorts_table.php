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
        Schema::create('url_shorts', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('status')->default(1);
            $table->bigInteger('user_id')->nullable()->comment('user_id');
            $table->string('url_short', 50)->comment('url');
            $table->string('url_real', 250)->comment('url real');
            $table->string('title', 250)->comment('title');

            $table->boolean('is_public')->default(1);
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
        Schema::dropIfExists('url_shorts');
    }
};
