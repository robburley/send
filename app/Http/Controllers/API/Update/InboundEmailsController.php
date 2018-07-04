<?php

namespace App\Http\Controllers\API\Update;

use App\Http\Controllers\Controller;
use App\Http\Resources\InboundEmailResource;
use App\Models\Inbound\InboundEmail;

class InboundEmailsController extends Controller
{
    public function index()
    {
        $emails = InboundEmail::inInbox()
                              ->belongsToUser()
                              ->today()
                              ->get();

        return InboundEmailResource::collection($emails);
    }
}
