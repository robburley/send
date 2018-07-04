<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class OutboundEmailResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'to'          => $this->to->pluck('email_address')->implode(', '),
            'from'        => $this->user->email,
            'cc'          => $this->cc->pluck('email_address')->implode(', '),
            'subject'     => $this->subject,
            'content'     => $this->content,
            'received'    => $this->created_at->toDateTimeString(),
            'read'        => 1,
            'active'      => false,
            'attachments' => OutboundEmailAttachmentResource::collection($this->attachments),
            'type'        => 'outbound',
            'deleted' => $this->deleted_at ? 1 : 0,
        ];
    }
}
