<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Producer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    protected $casts = [
        'created_at' => 'date:d-m-Y H:i:s',
        'updated_at' => 'date:d-m-Y H:i:s',
    ];

    public function movies(): BelongsToMany {
        return $this->belongsToMany(Movie::class);
    }
}
