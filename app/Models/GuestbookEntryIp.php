<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class GuestbookEntryIp extends Model
{
    protected $fillable = [
        'ip_hash',
    ];

    public function guestbookEntry()
    {
        return $this->belongsTo(GuestbookEntries::class);
    }

    public $timestamps = true;
}
