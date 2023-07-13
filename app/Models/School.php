<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function classrooms(): HasMany
    {
        return $this->hasMany(School::class);
    }
}
