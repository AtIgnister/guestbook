<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Concerns\VisibilityRestriction;
use App\Models\Concerns\Searchable;
use App\Helpers\IpHelper;
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
            $entry->ip()->create([
                'ip_hash' => IpHelper::ipHash(Request::ip()),
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
    
    public function ip()
    {
        return $this->hasOne(GuestbookEntryIp::class);
    }
}
