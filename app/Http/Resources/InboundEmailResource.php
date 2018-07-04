<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class InboundEmailResource extends Resource
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
            'from'        => $this->from,
            'cc'          => $this->cc->pluck('email_address')->implode(', '),
            'subject'     => $this->subject,
            'content'     => $this->content,
            'received'    => $this->created_at->toDateTimeString(),
            'read'        => $this->read,
            'active'      => false,
            'attachments' => InboundEmailAttachmentResource::collection($this->attachments),
            'type'        => 'inbound',
            'deleted'     => $this->deleted_at ? 1 : 0,
        ];
    }
}
