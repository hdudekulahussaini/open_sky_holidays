<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AdventureCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'status',
    ];

    public function adventure(): HasOne
    {
        return $this->hasOne(Adventure::class);
    }
}
