<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'title',
        'winner'
    ];

    protected $attributes = [
        'winner' => 'no'
    ];

    protected $casts = [
        'created_at' => 'date:d-m-Y H:i:s',
        'updated_at' => 'date:d-m-Y H:i:s',
    ];

    public function producers(): BelongsToMany {
        return $this->belongsToMany(Producer::class);
    }

    public function studios(): BelongsToMany {
        return $this->belongsToMany(Studio::class);
    }
}
