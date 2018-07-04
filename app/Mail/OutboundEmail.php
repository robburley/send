<?php

namespace App\Mail;

use \App\Models\Outbound\OutboundEmail as OutboundMailObject;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OutboundEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;

    /**
     * Create a new message instance.
     *
     * @param OutboundMailObject $email
     */
    public function __construct(OutboundMailObject $email)
    {
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->from($this->email->user);

        if ($this->email->cc) {
            foreach ($this->email->attachments as $attachment) {
                $mail->attach(storage_path('app/' . $attachment->location . $attachment->name));
            }
        }

        return $mail->view('emails.template');
    }
}
