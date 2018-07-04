<?php

namespace App\Models\Inbound;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InboundEmail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'folder_id',
        'from',
        'subject',
        'content',
        'read',
        'deleted_at',
    ];

    protected $with = [
        'folder',
        'attachments',
        'to',
        'cc',
    ];

    public function folder()
    {
        return $this->belongsTo(Folder::class);
    }

    public function attachments()
    {
        return $this->hasMany(InboundAttachment::class);
    }

    public function to()
    {
        return $this->hasMany(InboundEmailsTo::class);
    }

    public function cc()
    {
        return $this->hasMany(InboundEmailsCc::class);
    }

    public function scopeInInbox($query)
    {
        $query->where('folder_id', 0)
              ->orWhereNull('folder_id');
    }

    public function scopeInFolder($query, $folder)
    {
        $query->where('folder_id', $folder);
    }

    public function scopeBelongsToUser($query)
    {
        $query->whereHas('to', function ($query) {
            return $query->where('email_address', auth()->user()->email);
        });
    }

    public function scopeToday($query)
    {
        $query->where('created_at', '>', Carbon::now()->startOfDay());
    }

    public function sendTo($people)
    {
        collect($people)->filter()->each(function ($person) {
            $this->to()->create([
                'email_address' => trim($person),
            ]);
        });
    }

    public function addCc($people)
    {
        collect($people)
            ->filter()
            ->each(function ($person) {
                $this->cc()->create([
                    'email_address' => trim($person),
                ]);
            });
    }

    public function storeAttachments($parser)
    {
        $location = 'attachments/inbound/' . $this->id . '/';

        $attachmentLocation = storage__path() . '/' . $location;

        $parser->saveAttachments($attachmentLocation);

        foreach ($parser->getAttachments() as $attachment) {
            $this->attachments()->create([
                'location' => $location,
                'name'     => $attachment->getFilename(),
            ]);
        }
    }
}
