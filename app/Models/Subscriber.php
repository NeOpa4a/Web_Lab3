<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    protected $fillable = [
        'email',
        'name',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}
