<?php

namespace App\Console\Commands;

use App\Events\EmailReadyToBeSent;
use App\Models\Outbound\OutboundEmail;
use Illuminate\Console\Command;

class CheckForNewOutboundMail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:email-ready-to-be-sent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send email';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $emails = OutboundEmail::whereNull('sent_at')
                               ->get();

        $emails->each(function ($email) {
            event(new EmailReadyToBeSent($email));
        });
    }
}
