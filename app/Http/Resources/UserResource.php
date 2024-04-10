<?php

namespace App\Http\Resources;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use function App\Helpers\adminRole;
use function App\Helpers\agentRole;


/**
 * @mixin User
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'email' => $this->email,
            'role'  => new RoleResource($this->role),
            'token' => $this->when($request->segment(2) == 'register', function () use ($request) {
                return $request->token;
            }),
        ];
    }

//    public function with(Request $request): array
//    {
//        return [
//            'token' => $request->token
//        ];
//    }

}
