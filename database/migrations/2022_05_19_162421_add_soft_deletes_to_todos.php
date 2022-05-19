<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSoftDeletesToTodos extends Migration {
    public function up() {
        Schema::table('todos', function(Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->foreignId('user_id')->change()->constrained()->restrictOnDelete();
            $table->dropForeign(['category_id']);
            $table->foreignId('category_id')->change()->constrained()->restrictOnDelete();

            $table->boolean('done')->default('0')->change();

            $table->softDeletes()->after('done');
        });
    }

    public function down() {
        Schema::table('todos', function(Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->foreignId('user_id')->change()->constrained()->cascadeOnDelete();
            $table->dropForeign(['category_id']);
            $table->foreignId('category_id')->change()->constrained()->cascadeOnDelete();

            $table->enum('done', ['0', '1'])->default('0')->change();

            $table->dropSoftDeletes();
        });
    }
}
