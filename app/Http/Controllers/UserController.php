<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index(): JsonResponse
    {
        $users = User::all();
        return response()->json(new UserCollection($users));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'first-name' => 'required|string|max:255',
            'last-name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'birthdate' => 'required|date',
            'has-insurance' => 'boolean',
        ]);

        $user = User::create($validatedData);
        return response()->json(new UserResource($user), 201);
    }

    /**
     * Display the specified user.
     */
    public function show(User $user): JsonResponse
    {
        return response()->json(new UserResource($user));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user): JsonResponse
    {
        $validatedData = $request->validate([
            'first-name' => 'sometimes|required|string|max:255',
            'last-name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|string|min:8',
            'birthdate' => 'sometimes|required|date',
            'has-insurance' => 'sometimes|boolean',
        ]);

        $user->update($validatedData);
        return response()->json(new UserResource($user));
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return response()->json(null, 204);
    }

    /**
     * Display the movies of a specific user.
     */
    public function userMovies(User $user): JsonResponse
    {
        $movies = $user->movies;
        return response()->json($movies);
    }

    /**
     * Attach a movie to a user.
     */
    public function attachMovie(Request $request, User $user): JsonResponse
    {
        $validatedData = $request->validate([
            'movie_id' => 'required|exists:movies,id',
        ]);

        $user->movies()->attach($validatedData['movie_id']);
        return response()->json(['message' => 'Movie added to user successfully.'], 200);
    }

    /**
     * Detach a movie from a user.
     */
    public function detachMovie(Request $request, User $user): JsonResponse
    {
        $validatedData = $request->validate([
            'movie_id' => 'required|exists:movies,id',
        ]);

        $user->movies()->detach($validatedData['movie_id']);
        return response()->json(['message' => 'Movie removed from user successfully.'], 200);
    }
}
