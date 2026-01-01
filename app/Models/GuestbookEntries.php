<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Concerns\VisibilityRestriction;
use App\Models\Concerns\Searchable;
use App\Helpers\IpHash;
use Illuminate\Support\Facades\Request;

class GuestbookEntries extends Model
{
    use HasUuids, VisibilityRestriction, Searchable;
    protected $fillable = [ 
        "name",
        "website",
        "comment",
        "approved"
    ];
    protected array $searchable = [
        'name',
        'website',
        'comment',
    ];

    protected $casts = [
        'approved' => 'boolean',
    ];

    public function guestbook(): BelongsTo {
        return $this->belongsTo(Guestbook::class);
    }

    public static function booted() {
        static::created(function (GuestbookEntries $entry) {
            $entry->ips()->create([
                'ip_hash' => IpHash::ipHash(Request::ip()),
            ]);
        });
    }

    public function getIsApprovedLabel() {
        return $this->guestbook->requires_approval
            ? ($this->approved ? 'Yes' : 'No')
            : '-';
    }

    public function isApproved(): bool { 
        return $this->guestbook->requires_approval
        ? ($this->approved ? true : false)
        : true;
    }
    
    public function ips()
    {
        return $this->hasMany(GuestbookEntryIp::class);
    }
}
