<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Builder;

class PrivacyPolicy extends Model
{
    use HasUuids;
    protected $fillable = [ 
        "content",
        "change_summary",
        "visible",
    ];

    protected $casts = [
        'visible' => 'boolean',
        'is_draft' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function publish() {
        if($this->published_at) {
            return;
        }

        $this->is_draft = false;
        $this->published_at = now();
        $this->save();
    }

    public static function publicList(): Builder {
        return PrivacyPolicy::where('visible', true)
            ->where('is_draft', false)
            ->orderByDesc('published_at');
    }

    public static function getCurrent() {
        return self::publicList()->first();
    }
}
