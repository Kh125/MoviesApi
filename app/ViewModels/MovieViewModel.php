<?php

namespace App\ViewModels;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Spatie\ViewModels\ViewModel;

class MovieViewModel extends ViewModel
{
    public $movie;

    public function __construct($movie)
    {
        $this->movie = $movie;
    }

    public function movie(){           
        if(Arr::exists($this->movie, 'videos')){
            if($this->movie['videos']['results']){
                $videos = 'https://www.youtube.com/embed/'. $this->movie['videos']['results'][0]['key'];
            }
            else{
                $videos = '';
            }            
        }
        else{
            $videos = '';
        }

        if(Arr::exists($this->movie, 'videos')){
            return collect($this->movie)->merge([
                'poster_path' => $this->movie['poster_path'] ? 'https://image.tmdb.org/t/p/w500' . $this->movie['poster_path'] : 'https://ui-avatars.com/api/?size=500&name='. $this->movie['original_title'] ,
                'vote_average' => $this->movie['vote_average'] * 10 . '%',
                'release_date' => Carbon::parse($this->movie['release_date'])->format('M d, y'),
                'genres' => collect($this->movie['genres'])->pluck('name')->flatten()->implode(', '),
                'crews' => collect($this->movie['credits']['crew'])->take(2),
                'casts' => collect($this->movie['credits']['cast'])->take(5),
                'backdrops' => collect($this->movie['images']['backdrops'])->take(9),
                'videos' => $videos,
            ])->only('id', 'poster_path', 'vote_average', 'release_date', 'genres', 'crews', 'backdrops', 'original_title', 'overview', 'videos', 'casts');
        }else{
            $movie = [];
            return $movie;
        }

        
    }
}
