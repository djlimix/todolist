<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSharedTodosTable extends Migration {
    public function up() {
        Schema::create('shared_todos', function(Blueprint $table) {
            $table->id();

            $table->foreignId('todo_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('shared_todos');
    }
}
