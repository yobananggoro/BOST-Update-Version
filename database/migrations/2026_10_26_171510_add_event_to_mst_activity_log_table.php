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
        Schema::table('mst_activity_log', function (Blueprint $table) {
            // Menambahkan kolom event setelah kolom batch_uuid
            $table->string('event')->nullable()->after('batch_uuid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mst_activity_log', function (Blueprint $table) {
            $table->dropColumn('event');
        });
    }
};
