<?php

namespace App\Http\Controllers\Emails;

use App\Http\Controllers\Controller;
use App\Models\Inbound\Folder;

class FolderController extends Controller
{
    public function index($folderName)
    {
        $folder = Folder::where('slug', $folderName)
                        ->where('user_id', auth()->user()->id)
                        ->firstOrFail();

        return view('inbox.index', [
            'dataUrl'   => '/api/emails/folder/' . $folder->slug,
            'updateUrl' => '/api/emails/folder/update/' . $folder->slug,
            'folder'    => $folder->id,
        ]);
    }
}
