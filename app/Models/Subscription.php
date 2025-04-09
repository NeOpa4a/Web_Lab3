<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'service',
        'topic',
        'payload',
        'expired_at',
        'subscriber_id'
    ];

    protected $casts = [
        'payload' => 'array',
        'expired_at' => 'datetime'
    ];

    //
}
