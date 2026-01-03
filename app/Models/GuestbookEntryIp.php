<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use App\Models\GuestbookEntries;

class GuestbookEntryIp extends Model
{
    use HasUuids;
    protected $fillable = [
        'ip_hash',
    ];

    public function guestbookEntry()
    {
        return $this->belongsTo(GuestbookEntries::class);
    }

    public $timestamps = true;
}
