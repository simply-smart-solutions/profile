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
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            // Basic Info
            $table->integer('serial')->default(0);
            $table->string('name');
            $table->string('designation')->nullable(); // e.g., Web Developer, UI Designer
            $table->text('bio')->nullable();

            // Profile Image
            $table->string('photo')->nullable(); // store relative path (e.g., storage/files/team/john.jpg)

            // Social Media Links
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('instagram')->nullable();

            // Additional
            $table->integer('order')->default(0); // for sorting display order
            $table->boolean('status')->default(true); // active/inactive toggle
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teams');
    }
};
