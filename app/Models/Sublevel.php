<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sublevel extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    public function classrooms(): HasMany
    {
        return $this->hasMany(Classroom::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }
}
