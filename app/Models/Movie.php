<?php

namespace App\Models;

use App\Enums\Genre;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'genre',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'genre' => Genre::class,
    ];

    /**
     * The users that belong to the movie.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'movie_user');
    }
}
