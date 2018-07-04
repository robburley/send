<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\InboundEmailResource;
use App\Models\Inbound\InboundEmail;

class InboundEmailsController extends Controller
{
    public function index()
    {
        $emails = InboundEmail::inInbox()
                              ->belongsToUser()
                              ->get();

        return InboundEmailResource::collection($emails);
    }

    public function update($email)
    {
        $email->update(request()->only([
            'read',
            'deleted_at',
            'folder_id',
        ]));

        return $email;
    }

    public function destroy(InboundEmail $email)
    {
        $email->delete();

        return $email;
    }
}
