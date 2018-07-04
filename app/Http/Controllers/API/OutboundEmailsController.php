<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendEmailRequest;
use App\Http\Resources\OutboundEmailResource;

class OutboundEmailsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return OutboundEmailResource::collection(auth()->user()->outboundEmails);
    }

    public function store(SendEmailRequest $request)
    {
        $email = auth()->user()->outboundEmails()->create([
            'subject' => $request->input('subject'),
            'content' => $request->input('content'),
        ]);

        $email->sendTo($request->input('to'));

        $email->addCc($request->input('cc'));

        $request->input('files') && $email->addAttachments($request->input('files'));

        return $email->load('to', 'cc', 'attachments');
    }
}
