<?php

namespace App\Http\Controllers\Emails;

use App\Http\Controllers\Controller;

class InboxController extends Controller
{
    public function index()
    {
        return view('inbox.index', [
            'dataUrl'   => '/api/emails/folder/inbox',
            'updateUrl' => '/api/emails/folder/update/inbox',
        ]);
    }
}
