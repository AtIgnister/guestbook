<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Concerns\VisibilityRestriction;
use App\Models\Concerns\Searchable;
use App\Helpers\IpHelper;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;

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
    public function entryUserIsBanned() {
        if(Auth::user()->hasRole('admin')) {
            return IpHelper::isBannedByIpHash($this, null);
        }

        $guestbook = $this->guestbook;
        return IpHelper::isBannedByIpHash($this, $guestbook);
    }

    public function getIpBan()
    {
        if (!$this->ip) {
            return null;
        }

        return IpBan::query()
            ->whereHas('guestbookEntryIp', function ($query) {
                $query->where('ip_hash', $this->ip->ip_hash);
            })
            ->where(function ($query) {
                $query->where('is_global', true)
                    ->orWhere('guestbook_id', $this->guestbook_id);
            })
        ->first();
    }
    
    public function ip()
    {
        return $this->hasOne(GuestbookEntryIp::class);
    }

    public function scopeOwnedBy($query, $user)
    {
        return $query->whereHas('guestbook', fn ($q) =>
            $q->whereBelongsTo($user)
        );
    }
}
