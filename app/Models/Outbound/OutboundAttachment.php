<?php

namespace App\Models\Outbound;

use Illuminate\Database\Eloquent\Model;

class OutboundAttachment extends Model
{
    protected $fillable = [
        'name',
        'location',
    ];

    public function email()
    {
        return $this->belongsTo(OutboundEmail::class);
    }
}
