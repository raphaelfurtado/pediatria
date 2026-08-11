<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('content')->nullable();
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
        });

        // Páginas institucionais iniciais (em branco, prontas para preencher).
        $now = now();
        $seed = [
            ['title' => 'Diretoria', 'slug' => 'diretoria'],
            ['title' => 'Estatuto', 'slug' => 'estatuto'],
            ['title' => 'Missão', 'slug' => 'missao'],
            ['title' => 'Departamentos Científicos', 'slug' => 'departamentos-cientificos'],
        ];
        foreach ($seed as $i => $page) {
            DB::table('pages')->insert([
                'title' => $page['title'],
                'slug' => $page['slug'],
                'content' => null,
                'is_active' => true,
                'order' => $i,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
