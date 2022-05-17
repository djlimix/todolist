<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserIdToCategories extends Migration {
    public function up() {
        Schema::table('categories', function(Blueprint $table) {
            $table->foreignId('user_id')->after('id')->constrained()->cascadeOnDelete();
        });
    }

    public function down() {
        Schema::table('categories', function(Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });
    }
}
