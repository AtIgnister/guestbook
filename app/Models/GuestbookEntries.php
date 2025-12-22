<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GuestbookEntries extends Model
{
    protected $fillable = [ 
        "name",
        "website",
        "comment"
    ];

    public function guestbook(): BelongsTo {
        return $this->belongsTo(Guestbook::class);
    }
}
