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
        Schema::create('artists', function (Blueprint $table) {
            $table->uuid('artist_id')->primary();
            $table->foreignUuid('profile_id')
                ->references('profile_id')
                ->on('profiles')
                ->onDelete('cascade');

        });

        Schema::create('comment_images', function (Blueprint $table) {
            $table->uuid('comment_image_id')->primary();
            $table->text('comment_image_url');
            $table->foreignUuid('profile_id')
                ->references('profile_id')
                ->on('profiles')
                ->onDelete('cascade');
            $table->foreignUuid('comment_id')
                ->references('comment_id')
                ->on('comments')
                ->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('post_images', function (Blueprint $table) {
            $table->uuid('post_image_id')->primary();
            $table->text('post_image_url');
            $table->foreignUuid('profile_id')
                ->references('profile_id')
                ->on('profiles')
                ->onDelete('cascade');
            $table->foreignUuid('post_id')
                ->references('post_id')
                ->on('posts')
                ->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('collection_images',function (Blueprint $table) {
            $table->uuid('collection_image_id')->primary();
            $table->foreignUuid('collection_id')
                ->references('collection_id')
                ->on('collections')
                ->onDelete('cascade');
            $table->foreignUuid('profile_id')
                ->references('profile_id')
                ->on('profiles')
                ->onDelete('cascade');
            $table->text('work_image_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artists');
        Schema::dropIfExists('comment_images');
        Schema::dropIfExists('post_images');
        Schema::dropIfExists('collection_images');
    }
};
