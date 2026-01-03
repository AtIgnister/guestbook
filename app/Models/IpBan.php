<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IpBan extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'guestbook_id',
        'guestbook_entry_ip_id',
    ];

    protected $guarded = ['is_global'];

    protected $casts = [
        'is_global' => 'boolean',
    ];

    public function guestbookEntryIp(): BelongsTo
    {
        return $this->belongsTo(GuestbookEntryIp::class);
    }
    public function guestbook(): BelongsTo
    {
        return $this->belongsTo(Guestbook::class);
    }
}
