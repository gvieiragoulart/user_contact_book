<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'name'      => $this->name,
            'secondName'   => $this->second_name,
            'email'=> $this->email,
            'number'=> $this->number,
            'image_path'=> $this->image_path ?? '',
        ];
    }
}
