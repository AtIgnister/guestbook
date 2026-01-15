<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    use HasUuids;

    protected $fillable = [
    'email', 'role'
];
}
