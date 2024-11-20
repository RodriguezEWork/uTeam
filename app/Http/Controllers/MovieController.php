<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class MovieController extends Controller
{
    /**
     * Store a newly created movie in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'genre' => 'required|integer',
        ]);

        $movie = Movie::create($validatedData);
        return response()->json($movie, 201);
    }

    /**
     * Update a movie.
     */
    public function update(Request $request, Movie $movie): JsonResponse
    {
        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'genre' => 'sometimes|required|integer',
        ]);

        $movie->update($validatedData);
        return response()->json(['message' => 'Movie updated successfully.'], 200);
    }

    /**
     * Delete a movie.
     */
    public function destroy(Movie $movie): JsonResponse
    {
        $movie->delete();
        return response()->json(['message' => 'Movie removed successfully.'], 200);
    }
}
