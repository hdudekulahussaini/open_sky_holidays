<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutOurCoreValue extends Model
{
    use HasFactory;

    protected $table = 'about_our_core_values';

    protected $fillable = [
        'title',
        'description',
    ];
}
