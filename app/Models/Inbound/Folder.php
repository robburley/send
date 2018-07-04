<?php

namespace App\Models\Inbound;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use Sluggable;

    const PROTECTED_FOLDER_NAMES = [
        'Inbox',
        'Sent',
        'Trash',
    ];

    protected $fillable = [
        'name',
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public function emails()
    {
        return $this->hasMany(InboundEmail::class);
    }
}
