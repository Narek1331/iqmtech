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
        Schema::create('data_statuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('data_id');
            $table->unsignedBigInteger('status_id');

            // $table->foreign('data_id')
            // ->references('id')
            // ->on('datas')
            // ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_statuses');
    }
};
