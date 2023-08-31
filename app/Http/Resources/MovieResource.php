<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */

    public static $wrap = 'movie';
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'title' => $this->resource->title,
            'genre' => $this->resource->genre,
            'description' => $this->resource->description,
            'rating' => $this->resource->rating,
            'picture' => $this->resource->picture,
            'studio' => $this->resource->studio,
            'user' => new UserResource($this->resource->user)
        ];
    }
}
