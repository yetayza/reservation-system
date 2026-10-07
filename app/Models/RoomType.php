<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RoomType extends Model
{
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }
    protected $fillable = [
    'category_id',
    'name',
    'description',
];
}