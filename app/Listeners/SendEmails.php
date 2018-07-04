<?php

namespace App\Listeners;

use App\Events\EmailReadyToBeSent;
use App\Mail\OutboundEmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class SendEmails
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  EmailReadyToBeSent $event
     * @return void
     */
    public function handle(EmailReadyToBeSent $event)
    {
        try {
            $to = $event->email()->to->pluck('email_address')->implode(', ');

            $mail = Mail::to($to);

            if ($event->email()->cc->count() > 0) {
                $cc = $event->email()->cc->pluck('email_address')->implode(', ');

                $mail->cc($cc);
            }

            $mail->send(new OutboundEmail($event->email()));

            $event->email()->update([
                'sent_at' => Carbon::now(),
            ]);
        } catch (\Exception $e) {
            $event->email()->update([
                'failed_at'      => Carbon::now(),
                'failed_message' => $e->getMessage(),
            ]);
        }
    }
}
