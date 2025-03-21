<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_medical_cases', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained( 'users' )->cascadeOnDelete();
            $table->foreignId('medical_case_id')->constrained( 'medical_cases' )->cascadeOnDelete();
            $table->primary(['user_id', 'medical_case_id']);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_medical_cases');
    }
};
