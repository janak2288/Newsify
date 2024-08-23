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
        Schema::create('sources', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo')->nullable();
            $table->string('json_url');
            $table->timestamps();
        });

        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('source_id')->constrained('sources');
            $table->string('title');
            $table->string('news_url');
            $table->string('thumbnail_url')->nullable();
            $table->text('news_overview')->nullable();
            $table->timestamp('published_date');
            $table->timestamps();

            // Add a unique index for source_id and news_url combination
            $table->unique(['source_id', 'news_url']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // Drop the unique index before dropping the table
            $table->dropUnique(['source_id', 'news_url']);
        });

        Schema::dropIfExists('posts');
        Schema::dropIfExists('sources');
    }
};
