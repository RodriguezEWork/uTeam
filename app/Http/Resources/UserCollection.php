<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  mixed  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'data' => $this->collection->map(function ($user) {
                return [
                    'id' => $user->id,
                    'first-name' => $user->name,
                    'last-name' => $user->last_name,
                    'birthdate' => $user->birthdate,
                    'has-insurance' => $user->has_insurance,
                    'favourite-movies' => $user->movies->map(function ($movie) {
                        return [
                            'title' => $movie->title,
                            'genre' => $movie->genre,
                        ];
                    }),
                ];
            }),
        ];
    }
} 