<?php

namespace App\Http\Resources;

use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'roles' => $this->getRoles(),
            'abilities' => AbilityResource::collection($this->getAbilities()),
            'forbidden' => AbilityResource::collection($this->getForbiddenAbilities())
        ]);
    }
}
