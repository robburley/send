<?php

namespace App\Http\Controllers\Emails;

use App\Http\Controllers\Controller;
use App\Models\Inbound\InboundEmail;
use Illuminate\Support\Facades\Log;
use PhpMimeMailParser\Parser;

class CatchInboundEmailController extends Controller
{
    public function store()
    {
        Log::info('requested');

        $messages = json_decode(file_get_contents('php://input'));

        Log::info($messages);

        if ($messages) {
            foreach ($messages as $msg) {
                $emailBody = $msg->msys->relay_message->content->email_rfc822;

                if ($msg->msys->relay_message->content->email_rfc822_is_base64) {
                    $emailBody = base64_decode($emailBody);
                }

                $parser = (new Parser())->setText($emailBody);

                if (!empty($parser->getMessageBody('html'))) {
                    $content = $parser->getMessageBody('html');
                } else {
                    $content = $parser->getMessageBody('text');
                }

                $email = InboundEmail::create([
                    'from'    => $parser->getHeader('from'),
                    'subject' => $parser->getHeader('subject'),
                    'content' => $content,
                ]);

                $email->sendTo($parser->getHeader('to'));

                $email->addCc($parser->getHeader('cc'));

                $email->storeAttachments($parser);

                Log::info($email);
            }

            Log::info('complete');

            return response()
                ->json(['complete' => 'true']);
        }

        Log::info('failed');

        return response()
            ->json(['complete' => 'false']);
    }
}
