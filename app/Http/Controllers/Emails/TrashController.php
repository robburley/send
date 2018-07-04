<?php

namespace App\Http\Controllers\Emails;

use App\Http\Controllers\Controller;

class TrashController extends Controller
{
    public function index()
    {
        return view('inbox.index', [
            'dataUrl'   => '/api/emails/folder/trash',
            'updateUrl' => '/api/emails/folder/update/trash',
        ]);
    }
}
