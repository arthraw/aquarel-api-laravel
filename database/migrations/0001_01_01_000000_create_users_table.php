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
        // 1. Tabelas Base
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('user_id')->primary();
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        Schema::create('profiles', function (Blueprint $table) {
            $table->uuid('profile_id')->primary();
            $table->text('bio')->nullable();
            $table->string('name');
            $table->foreignUuid('user_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->text('avatar_url')->nullable();
            $table->text('banner_url')->nullable();
            $table->text('instagram_profile_url')->nullable();
            $table->text('behance_profile_url')->nullable();
            $table->string('category')->nullable();
            $table->timestamps();
        });

        // 2. Tabelas Relacionadas a Perfis e Usuários
        Schema::create('posts', function (Blueprint $table) {
            $table->uuid('post_id')->primary();
            $table->text('content');
            $table->foreignUuid('profile_id')->constrained('profiles', 'profile_id')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('comments', function (Blueprint $table) {
            $table->uuid('comment_id')->primary();
            $table->text('content');
            $table->foreignUuid('profile_id')->constrained('profiles', 'profile_id')->onDelete('cascade');
            $table->foreignUuid('post_id')->constrained('posts', 'post_id')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('follows', function (Blueprint $table) {
            $table->uuid('follow_id')->primary();
            $table->foreignUuid('follower_id')->constrained('profiles', 'profile_id')->onDelete('cascade');
            $table->foreignUuid('followed_id')->constrained('profiles', 'profile_id')->onDelete('cascade');
            $table->timestamps();

            $table->unique(['follower_id', 'followed_id']);
        });


        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('notification_id')->primary();
            $table->foreignUuid('profile_id')->constrained('profiles','profile_id')->onDelete('cascade');
            $table->string('title');
            $table->text('message');
            $table->boolean('read')->default(false);
            $table->timestamps();
        });

        Schema::create('likes', function (Blueprint $table) {
            $table->uuid('like_id')->primary();
            $table->foreignUuid('profile_id')->constrained('profiles', 'profile_id')->onDelete('cascade');
            $table->uuid('likeable_id'); // ID do item curtido (post, comentário ou trabalho)
            $table->string('likeable_type'); // Tipo do item curtido (modelo correspondente)
            $table->timestamps();
        });

        // 3. Tabelas de Artes e Coleções
        Schema::create('collections', function (Blueprint $table) {
            $table->uuid('collection_id')->primary();
            $table->string('name');
            $table->text('description');
            $table->string('category');
            $table->foreignUuid('profile_id')->constrained('profiles', 'profile_id')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('works', function (Blueprint $table) {
            $table->uuid('work_id')->primary();
            $table->string('name')->unique();
            $table->text('description');
            $table->string('category');
            $table->foreignUuid('profile_id')->constrained('profiles','profile_id')->onDelete('cascade');
            $table->foreignUuid('collection_id')->constrained('collections', 'collection_id')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('work_images', function (Blueprint $table) {
            $table->uuid('work_image_id')->primary();
            $table->foreignUuid('work_id')->constrained('works','work_id')->onDelete('cascade');
            $table->foreignUuid('profile_id')->constrained('profiles','profile_id')->onDelete('cascade');
            $table->text('work_image_url');
            $table->timestamps();
        });

        // 4. Eventos
        Schema::create('events', function (Blueprint $table) {
            $table->uuid('event_id')->primary();
            $table->string('name');
            $table->text('description');
            $table->string('location');
            $table->string('category');
            $table->timestamp('date_start');
            $table->timestamp('date_end');
            $table->text('event_image_url')->nullable();
            $table->timestamps();
        });

        Schema::create('event_profiles', function (Blueprint $table) {
            $table->uuid('event_profile_id')->primary();
            $table->foreignUuid('event_id')->constrained('events','event_id')->onDelete('cascade');
            $table->foreignUuid('profile_id')->constrained('profiles','profile_id')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('participants', function (Blueprint $table) {
            $table->uuid('participant_id')->primary();
            $table->foreignUuid('profile_id')->constrained('profiles','profile_id')->onDelete('cascade');
            $table->foreignUuid('event_id')->constrained('events','event_id')->onDelete('cascade');
            $table->unique(['profile_id', 'event_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
        Schema::dropIfExists('event_profiles');
        Schema::dropIfExists('events');
        Schema::dropIfExists('work_images');
        Schema::dropIfExists('works');
        Schema::dropIfExists('collections');
        Schema::dropIfExists('likes');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('follows');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('posts');
        Schema::dropIfExists('profiles');
        Schema::dropIfExists('users');
    }
};
