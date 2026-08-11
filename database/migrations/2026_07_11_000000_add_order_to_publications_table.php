<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('publications', function (Blueprint $table) {
            $table->integer('order')->default(0)->after('year');
        });

        // Ordem inicial cronológica: ano mais recente primeiro.
        $ids = DB::table('publications')->orderByDesc('year')->orderByDesc('id')->pluck('id');
        foreach ($ids as $i => $id) {
            DB::table('publications')->where('id', $id)->update(['order' => $i]);
        }
    }

    public function down(): void
    {
        Schema::table('publications', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
};
