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
            'first-name' => $this->name,
            'last-name' => $this->last_name, // Asegúrate de que este campo exista en tu modelo
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