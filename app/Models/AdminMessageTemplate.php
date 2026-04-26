<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminMessageTemplate extends Model
{
    protected $fillable = [
        'locale',
        'key',
        'subject',
        'body',
    ];
}
