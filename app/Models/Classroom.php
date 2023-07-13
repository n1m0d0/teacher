<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classroom extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function sublevel(): BelongsTo
    {
        return $this->belongsTo(sublevel::class);
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class);
    }

    public function assists()
    {
        return $this->hasMany(Attendance::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
