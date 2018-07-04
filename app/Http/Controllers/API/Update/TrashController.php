<?php

namespace App\Http\Controllers\Api\Update;

use App\Http\Controllers\Controller;
use App\Http\Resources\InboundEmailResource;
use App\Models\Inbound\InboundEmail;

class TrashController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $emails = InboundEmail::onlyTrashed()
                              ->belongsToUser()
                              ->today()
                              ->get();

        return InboundEmailResource::collection($emails);
    }
}
