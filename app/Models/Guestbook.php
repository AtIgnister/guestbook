<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\GuestbookEntries;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\Concerns\VisibilityRestriction;
use App\Models\Concerns\Searchable;

class Guestbook extends Model
{
    use HasUuids, VisibilityRestriction, Searchable;
    protected $fillable = [ 
        "name",
        "style",
        "description",
        'requires_approval',
    ];
    protected array $searchable = [
        'name',
        'description',
    ];

    protected $casts = [
        'requires_approval' => 'boolean',
    ];


    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function entries(): HasMany { 
        return $this->hasMany(GuestbookEntries::class);
    }

    public static function booted() {
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }
    
}
