<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model {
    use SoftDeletes;

    protected $fillable = ['category_id', 'text', 'done'];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function sharedWithUsers() {
        return $this->belongsToMany(User::class, 'shared_todos');
    }
}
