<?php

namespace App\Http\Controllers\Api\Update;

use App\Http\Controllers\Controller;
use App\Http\Resources\InboundEmailResource;
use App\Models\Inbound\Folder;
use App\Models\Inbound\InboundEmail;

class FolderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($folderName)
    {
        $folder = Folder::where('slug', $folderName)
                        ->where('user_id', auth()->user()->id)
                        ->first();

        $emails = InboundEmail::inFolder($folder->id)
                              ->belongsToUser()
                              ->today()
                              ->get();

        return InboundEmailResource::collection($emails);
    }
}
