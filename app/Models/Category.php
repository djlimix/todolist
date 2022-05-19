<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model {
    use SoftDeletes;

    protected $fillable = ['name'];
    protected $withCount = ['todos'];

    public function todos() {
        return $this->hasMany(Todo::class);
    }
}
