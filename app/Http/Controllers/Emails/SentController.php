<?php

namespace App\Http\Controllers\Emails;

use App\Http\Controllers\Controller;

class SentController extends Controller
{
    public function index()
    {
        return view('inbox.index', [
            'dataUrl'   => '/api/emails/folder/sent',
            'updateUrl' => '/api/emails/folder/update/sent',
        ]);
    }
}
