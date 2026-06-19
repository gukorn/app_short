<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->start(10000)->nocache();
            $table->smallInteger('status')->default(1);
            // $table->string('username');
            $table->string('password');
            $table->string('firstname', 200);
            $table->string('lastname', 200);
            //$table->string('nickname');
            $table->string('email', 200)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();

            $table->boolean('is_admin')->default(0);
            $table->bigInteger('credit_point')->default(0);

            //$table->timestamps();
            $table->dateTime('created_at');
            $table->bigInteger('created_by');
            $table->dateTime('updated_at');
            $table->bigInteger('updated_by');
        });

        DB::statement("ALTER TABLE users AUTO_INCREMENT = 10000;");
        DB::insert('insert into users (status, username, firstname, lastname, is_admin,  email, password,  created_at, created_by, updated_at, updated_by) values (?,?,?,?,?,?,?,?,?,?,?)', array(1, 'admin', 'Admin', 'dddd', 1,  'gukorn@gmail.com', bcrypt('123456'), '2020-03-17 09:47:57', 0, '2020-09-11 11:31:19', 1));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
