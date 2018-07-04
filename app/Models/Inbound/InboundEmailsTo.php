<?php

namespace App\Models\Inbound;

use Illuminate\Database\Eloquent\Model;

class InboundEmailsTo extends Model
{
    protected $fillable = [
        'email_address',
    ];

    protected $table = 'inbound_emails_to';

    public function email()
    {
        return $this->belongsTo(InboundEmail::class);
    }
}
