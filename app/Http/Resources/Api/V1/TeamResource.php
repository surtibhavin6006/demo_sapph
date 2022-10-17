<?php

namespace App\Http\Resources\Api\V1;

use App\Interfaces\TeamModelConstantInterface;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource implements TeamModelConstantInterface
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            self::ID => $this->{self::ID},
            self::NAME => $this->{self::NAME},
            self::IS_WINNER => $this->{self::IS_WINNER},
            self::STEP => $this->{self::STEP},
        ];
    }
}
