<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\GuestbookEntries;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GuestbookEntryIp extends Model
{
    use HasUuids, HasFactory;
    protected $fillable = [
        'ip_hash',
    ];
    

    public function guestbookEntry()
    {
        return $this->belongsTo(GuestbookEntries::class, 'guestbook_entries_id');
    }

    public function ipBans(): HasMany
    {
        return $this->hasMany(IpBan::class);
    }

    public $timestamps = true;
}
