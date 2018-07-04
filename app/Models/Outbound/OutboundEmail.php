<?php

namespace App\Models\Outbound;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OutboundEmail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'from',
        'subject',
        'content',
        'sent_at',
        'failed_at',
        'failed_message',
    ];

    protected $dates = [
        'sent_at',
        'failed_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $with = [
        'user',
        'attachments',
        'to',
        'cc',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attachments()
    {
        return $this->hasMany(OutboundAttachment::class);
    }

    public function to()
    {
        return $this->hasMany(OutboundEmailsTo::class);
    }

    public function cc()
    {
        return $this->hasMany(OutboundEmailsCc::class);
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

    public function addAttachments($files)
    {
        foreach ($files as $file) {
            $file->storeAs('attachments/outbound/' . $this->id . '/', $file->getClientOriginalName());

            $this->attachments()->create([
                'location' => 'attachments/outbound/' . $this->id . '/',
                'name'     => $file->getClientOriginalName(),
            ]);
        }
    }
}
