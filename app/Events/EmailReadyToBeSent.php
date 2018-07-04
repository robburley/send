<?php

namespace App\Events;

use App\Models\Outbound\OutboundEmail;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EmailReadyToBeSent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $email;

    /**
     * Create a new event instance.
     *
     * @param OutboundEmail $email
     */
    public function __construct(OutboundEmail $email)
    {
        $this->email = $email;
    }

    public function email()
    {
        return $this->email;
    }
}
