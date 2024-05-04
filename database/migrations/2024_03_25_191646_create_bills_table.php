<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

class CreateBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bills', function (Blueprint $table) {
            // $table->string('id')->primary();
            // $table->string('status')->default(0);
            // $table->unsignedBigInteger('user_id')->nullable();
            // $table->unsignedBigInteger('assignfor')->nullable();
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            // $table->foreign('assignfor')->references('id')->on('users')->onDelete('set null');
            $table->string('id')->primary();
            $table->string('status')->default(0);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('assign_for')->nullable();

            // Define foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('assign_for')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bills');
    }
}
