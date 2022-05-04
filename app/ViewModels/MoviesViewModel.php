<?php

namespace App\ViewModels;

use Carbon\Carbon;
use Spatie\ViewModels\ViewModel;

class MoviesViewModel extends ViewModel
{
    public $popular_movies;
    public $now_playing_movies;
    public $genres;

    public function __construct($popular_movies, $now_playing_movies, $genres)
    {
        $this->popular_movies = $popular_movies;
        $this->now_playing_movies = $now_playing_movies;
        $this->genres = $genres;
    }

    private function formatMovies($movies){
        return collect($movies)->map(function($movie){
            
            $genreFormatted = collect($movie['genre_ids'])->mapWithKeys(function($genre){
                return [$genre => $this->genres()->get($genre)];
            })->implode(', ');
            
            return collect($movie)->merge([
                'poster_path' => 'https://image.tmdb.org/t/p/w500' . $movie['poster_path'],
                'vote_-average' => $movie['vote_average'] * 10 . '%',
                'release_date' => Carbon::parse($movie['release_date'])->format('M d, y'),
                'genres' => $genreFormatted,
            ])->only(
                'poster_path', 'id', 'genre_ids', 'title', 'vote_average', 'overview', 'release_date', 'genres', 'original_title'
            );
        });
    }

    public function popular_movies(){
        return $this->formatMovies($this->popular_movies);
    }

    public function now_playing_movies(){
        return $this->formatMovies($this->now_playing_movies);
    }

    public function genres(){
        return collect($this->genres)->mapWithKeys(function($genre){
            return [$genre['id'] => $genre['name']];
        });
    }
}
