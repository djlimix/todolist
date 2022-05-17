<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model {
    protected $fillable = ['category_id', 'text', 'done'];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function shares() {
        return $this->belongsToMany(User::class, 'shared_todos');
    }
}
