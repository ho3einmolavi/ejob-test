<?php

namespace App\Http\Resources\Todo;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TodoCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public $collects = TodoResource::class;
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
