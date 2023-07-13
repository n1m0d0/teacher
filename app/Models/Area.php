<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function classrooms(): HasMany
    {
        return $this->hasMany(Classroom::class);
    }
}
