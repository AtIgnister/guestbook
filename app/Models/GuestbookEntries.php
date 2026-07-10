<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Concerns\VisibilityRestriction;
use App\Models\Concerns\Searchable;
use App\Helpers\IpHelper;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Casts\Attribute;

class GuestbookEntries extends Model
{
    use HasUuids, VisibilityRestriction, Searchable, HasFactory;
    protected $fillable = [ 
        "guestbook_id",
        "name",
        "website",
        "comment",
        "approved",
        "posted_at",
        "is_reply",
        "parent_entry_id"
    ];
    protected array $searchable = [
        'name',
        'website',
        'comment',
    ];

    protected $casts = [
        'approved' => 'boolean',
        'is_reply' => 'boolean',
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

        static::creating(function (GuestbookEntries $entry) {
            if (!isset($entry->posted_at) || !optional(auth()->user())->can('update', $entry->guestbook)) {
                $entry->posted_at = now();
            }
        });

        static::saving(function (GuestbookEntries $entry) {
            if ($entry->comment === null) {
                $entry->rendered_comment = null;
                return;
            }

            $options = config('markdown.commonmark_options');
            $renderer = new \App\Renderers\MDSandboxRenderer($options);

            $entry->rendered_comment = $renderer->convertToHtml($entry->comment);
        });


        static::deleting(function (GuestbookEntries $entry) {
            $entry->replies()->delete();
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
            return IpHelper::isBannedByIpHash($this->ip->ip_hash, null);
        }

        $guestbook = $this->guestbook;
        return IpHelper::isBannedByIpHash($this->ip->ip_hash, $guestbook);
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

    public function parent(): BelongsTo
    {
        return $this->belongsTo(GuestbookEntries::class, 'parent_entry_id');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(GuestbookEntries::class, 'parent_entry_id')
            ->orderBy('created_at');
    }

    public function getPreviousReply() {
        return $this::where('parent_entry_id', $this->parent_entry_id)
            ->where('created_at', '<', $this->created_at)
            ->latest('created_at')
            ->first();
    }

    public function getNextReply() {
        return $this::where('parent_entry_id', $this->parent_entry_id)
            ->where('created_at', '>', $this->created_at)
            ->oldest('created_at')
            ->first();
    }

    private function renderComment() {
        $options = config('markdown.commonmark_options');
        $renderer = new \App\Renderers\MDSandboxRenderer($options);

        return $renderer->convertToHtml($this->comment);
    }

    protected function renderedComment(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ?? $this->renderComment(),
        );
    }
}
