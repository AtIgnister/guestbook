<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Concerns\VisibilityRestriction;
use App\Models\Concerns\Searchable;

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
        static::creating(function ($model) {
            $model->id = Str::uuid();
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
    
}
