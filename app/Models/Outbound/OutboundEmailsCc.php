<?php

namespace App\Models\Outbound;

use Illuminate\Database\Eloquent\Model;

class OutboundEmailsCc extends Model
{
    protected $fillable = [
        'email_address',
    ];

    protected $table = 'outbound_emails_cc';

    public function email()
    {
        return $this->belongsTo(OutboundEmail::class);
    }
}
