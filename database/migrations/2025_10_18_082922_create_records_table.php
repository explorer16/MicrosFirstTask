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
        Schema::create('records', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('record_category_id');
            $table->unsignedBigInteger('amount');
            $table->text('comment');
            $table->date('date');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('record_category_id')
                ->references('id')
                ->on('record_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
