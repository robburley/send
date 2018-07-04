<?php

namespace App\Http\Controllers\API\Update;

use App\Http\Controllers\Controller;
use App\Http\Resources\OutboundEmailResource;

class OutboundEmailsController extends Controller
{
    public function index()
    {
        $emails = auth()->user()->outboundEmails()
                        ->today()
                        ->get();

        return OutboundEmailResource::collection($emails);
    }
}
