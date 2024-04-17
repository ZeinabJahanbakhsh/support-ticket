<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Activitylog\Models\Activity;

/**
 * @mixin Activity
 */
class LogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //$subject = explode("'\\'", $this->subject_type);

        return [
            'id'          => $this->id,
            'log_name'    => $this->log_name,
            'description' => $this->description,
            'event'       => $this->event,
            'subject_id'  => $this->subject_id,
            'subject'     => array_reverse(explode("\\", $this->subject_type))[0],
            'causer_type' => array_reverse(explode("\\", $this->causer_type))[0],
            'causer'      => new UserResource($this->causer),
            'causer_id'   => $this->causer_id,
            'properties'  => $this->properties,
            'created_at'  => $this->created_at->format('Y/m/d'),
        ];
    }


}
