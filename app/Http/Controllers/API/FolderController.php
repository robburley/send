<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateFolderRequest;
use App\Http\Resources\FolderResource;
use App\Http\Resources\InboundEmailResource;
use App\Models\Inbound\Folder;
use App\Models\Inbound\InboundEmail;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return FolderResource::collection(auth()->user()->folders);
    }

    public function store(CreateFolderRequest $request)
    {
        auth()->user()->folders()->create($request->all());

        return FolderResource::collection(auth()->user()->folders);
    }

    public function show($folderName)
    {
        $folder = Folder::where('slug', $folderName)
                        ->where('user_id', auth()->user()->id)
                        ->firstOrFail();

        $emails = InboundEmail::inFolder($folder->id)
                              ->belongsToUser()
                              ->get();

        return InboundEmailResource::collection($emails);
    }
}
