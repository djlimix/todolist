<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesToUsers extends Migration {
    public function up() {
        Schema::table('users', function(Blueprint $table) {
            $table->softDeletes()->after('remember_token');
        });
    }

    public function down() {
        Schema::table('users', function(Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}