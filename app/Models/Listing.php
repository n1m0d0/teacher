<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Listing extends Model
{
    use HasFactory;

    const Attended = 1;
    const Delay = 2;
    const Lack = 3;
    const Licencia = 4;

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
