<?php

namespace App\Http\Resources;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @mixin Ticket
 */
class TicketResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'attachment'  => $this->attachment,
            'priority'    => new PriorityResource($this->priority),
            'user'        => new UserResource($this->user),
            'status'      => new StatusResource($this->status),
            'category'    => CategoryResource::collection($this->categories),
        ];
    }
}
