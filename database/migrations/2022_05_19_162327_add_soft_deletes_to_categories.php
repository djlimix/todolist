<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesToCategories extends Migration {
    public function up() {
        Schema::table('categories', function(Blueprint $table) {
            $table->softDeletes()->after('name');
        });
    }

    public function down() {
        Schema::table('categories', function(Blueprint $table) {
            $table->dropSoftDeletes();
        });
    }
}
