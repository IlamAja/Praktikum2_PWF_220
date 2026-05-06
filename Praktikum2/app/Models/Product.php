<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = ['user_id', 'name', 'qty', 'price'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kategoris(): HasMany
    {
        return $this->hasMany(Kategori::class);
    }
}
