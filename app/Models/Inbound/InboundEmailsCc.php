<?php

namespace App\Models\Inbound;

use Illuminate\Database\Eloquent\Model;

class InboundEmailsCc extends Model
{
    protected $fillable = [
        'email_address',
    ];

    protected $table = 'inbound_emails_cc';

    public function email()
    {
        return $this->belongsTo(InboundEmail::class);
    }
}
