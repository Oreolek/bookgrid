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
        // List of books
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            // Book owner
            $table->foreignId('user_id')->constrained();
        });
        // Collaborators (not owners)
        Schema::create('books_collaborators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')->constrained();
            $table->foreignId('user_id')->constrained();
        });
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            // Assume books hold sections, sections hold text content.
            $table->text('content');
            $table->foreignId('book_id')->constrained();
            $table->unsignedInteger('order')->default(0);
            $table->nestedSet();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
        Schema::dropIfExists('books_collaborators');
        Schema::dropIfExists('sections');
    }
};