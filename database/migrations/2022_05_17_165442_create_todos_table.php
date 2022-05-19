<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTodosTable extends Migration {
    public function up() {
        Schema::create('todos', function(Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();

            $table->string('text');
            $table->enum('done', ['0', '1'])->default('0')->index();

            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('todos');
    }
}
