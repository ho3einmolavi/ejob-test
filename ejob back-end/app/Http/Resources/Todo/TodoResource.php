<?php

namespace App\Http\Resources\Todo;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class TodoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id ,
            'user_id' => $this->user_id ,
            'title' => $this->title ,
            'description' => $this->description ,
            'done' => $this->done ? true : false ,
            'user' => new UserResource($this->whenLoaded('user'))
        ];
    }
}
