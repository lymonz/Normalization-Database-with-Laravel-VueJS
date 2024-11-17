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
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mhs_id')->required();
            $table->unsignedBigInteger('matkul_id')->required();
            $table->string('nilai',1)->required();
            $table->timestamps();

            $table->foreign('mhs_id')->references('id')->on('mahasiswas')->onDelete('cascade');
            $table->foreign('matkul_id')->references('id')->on('mata_kuliahs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
