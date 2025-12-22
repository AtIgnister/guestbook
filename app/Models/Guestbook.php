<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\GuestbookEntries;

class Guestbook extends Model
{
    protected $fillable = [ 
        "name",
        "style"
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function entries(): HasMany { 
        return $this->hasMany(GuestbookEntries::class);
    }
}
