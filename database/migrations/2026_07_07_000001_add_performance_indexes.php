<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->index('published_at');
            $table->index('category');
            $table->index('is_featured');
            $table->index('deleted_at');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->index('date_start');
            $table->index('is_featured');
        });

        Schema::table('slides', function (Blueprint $table) {
            $table->index(['is_active', 'order']);
        });

        Schema::table('videos', function (Blueprint $table) {
            $table->index('is_active');
            $table->index('is_featured');
        });

        Schema::table('photo_albums', function (Blueprint $table) {
            $table->index('is_active');
        });

        Schema::table('menu_items', function (Blueprint $table) {
            $table->index(['is_active', 'order']);
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex(['published_at']);
            $table->dropIndex(['category']);
            $table->dropIndex(['is_featured']);
            $table->dropIndex(['deleted_at']);
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropIndex(['date_start']);
            $table->dropIndex(['is_featured']);
        });

        Schema::table('slides', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'order']);
        });

        Schema::table('videos', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
            $table->dropIndex(['is_featured']);
        });

        Schema::table('photo_albums', function (Blueprint $table) {
            $table->dropIndex(['is_active']);
        });

        Schema::table('menu_items', function (Blueprint $table) {
            $table->dropIndex(['is_active', 'order']);
        });
    }
};
