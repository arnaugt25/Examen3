<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Anunci extends Model
{
    protected $fillable = [
        'titol',
        'descripcio',
        'date',
        'hora',
        'email',
        'category_id'
    ];

    public function category() {
        return $this->BelongsTo(Category::class);
    }
}
