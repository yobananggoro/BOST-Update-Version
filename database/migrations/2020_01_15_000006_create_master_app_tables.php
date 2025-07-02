<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMasterAppTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_unit_kerja', function (Blueprint $table) {
            $table->string('kode', 4)->primary();
            $table->string('nama', 150);
            $table->string('parentkode', 4);
            $table->string('kodehc', 4)->nullable();
            $table->boolean('cabang');
            $table->boolean('cabang_rdn')->default(false);
            $table->string('kanwil', 10);
            $table->timestamps();

            $table->index(['kode', 'nama']);
        });

        Schema::create('app_user', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('username', 4)->unique();
            $table->string('password');
            $table->rememberToken();
            $table->string('session_id', 100)->nullable();
            $table->dateTime('last_activity')->nullable();
            $table->string('email', 80)->nullable();
            $table->unsignedSmallInteger('status')->comment('0: Tidak Aktif, 1: Aktif, 9: Blokir');
            $table->boolean('isLogin');
            $table->timestamps();

            $table->index(['id', 'username', 'email']);
        });

        Schema::create('app_profile', function (Blueprint $table) {
            $table->uuid('user_id');
            $table->string('nama', 80);
            $table->string('nip', 20);
            $table->string('hp', 16);
            $table->string('unit_kerja_kode', 4);
            $table->string('rolename', 30);
            $table->unsignedSmallInteger('idrole');

            $table->index(['user_id', 'nip']);
            $table->foreign('user_id')
                ->references('id')
                ->on('app_user')
                ->onDelete('cascade');
            $table->foreign('unit_kerja_kode')
                ->references('kode')
                ->on('app_unit_kerja')
                ->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_unit_kerja');
        Schema::dropIfExists('app_user');
        Schema::dropIfExists('app_profile');
        
    }
}
