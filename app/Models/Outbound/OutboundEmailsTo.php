<?php

namespace App\Models\Outbound;

use Illuminate\Database\Eloquent\Model;

class OutboundEmailsTo extends Model
{
    protected $fillable = [
        'email_address',
    ];

    protected $table = 'outbound_emails_to';

    public function email()
    {
        return $this->belongsTo(OutboundEmail::class);
    }
}
