<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  mixed  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'birthdate' => $this->birthdate,
            'has-insurance' => $this->has_insurance,
            'favourite-movies' => $this->movies->map(function ($movie) {
                return [
                    'title' => $movie->title,
                    'genre' => $movie->genre,
                ];
            }),
        ];
    }
} 