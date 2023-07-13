<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function sublevel(): BelongsTo
    {
        return $this->belongsTo(Sublevel::class);
    }

    public function classrooms(): BelongsToMany
    {
        return $this->belongsToMany(Classroom::class);
    }

    public function listings(): HasMany
    {
        return $this->hasMany(Listing::class);
    }
}
