<?php

namespace App\ViewModels;

use Carbon\Carbon;
use Spatie\ViewModels\ViewModel;

class ActorViewModel extends ViewModel
{
    public $actor;
    public $actor_external_ids;
    public $credits;
    public function __construct($actor, $actor_external_ids, $credits)
    {
        $this->actor = $actor;
        $this->actor_external_ids = $actor_external_ids;
        $this->credits = $credits;
    }

    public function actor(){
        return collect($this->actor)->merge([
            'birthday' => Carbon::parse($this->actor['birthday'])->format('M d, Y'),
            'age' => Carbon::parse($this->actor['birthday'])->age,
            'profile_path' => $this->actor['profile_path'] ? 'https://image.tmdb.org/t/p/w300/'.$this->actor['profile_path'] 
            : 'https://ui-avatars.com/api/?size=608&name='. $this->actor['name'] 
        ])->only(
            'id', 'name', 'homepage', 'profile_path', 'birthday', 'age', 'deathday', 'place_of_birth', 'gender', 'biography', 
        );
    }

    public function actor_external_ids(){
        return collect($this->actor_external_ids)->merge([
            'facebook' => $this->actor_external_ids['facebook_id'] ? 'https://facebook.com/' . $this->actor_external_ids['facebook_id'] : null,
            'instagram' => $this->actor_external_ids['instagram_id'] ? 'https://instagram.com/' . $this->actor_external_ids['instagram_id'] : null,
            'twitter' => $this->actor_external_ids['twitter_id'] ? 'https://twitter.com/' . $this->actor_external_ids['twitter_id'] : null,
        ])->only(
            'facebook', 'instagram', 'twitter'
        );
    }

    public function knownForTitles(){
        $castInfo = collect($this->credits)->get('cast');
        return collect($castInfo)->where('media_type', 'movie')->sortByDesc('popularity')->take(5)->map(function($p_movie){
            return collect($p_movie)->merge([
                'poster_path' => 'https://image.tmdb.org/t/p/w150_and_h225_bestv2/'. $p_movie['poster_path'],                
            ])->only('poster_path', 'id', 'title');
        });
    }

    public function credits(){
        $credits = collect($this->credits)->get('cast');
        return collect($credits)->map(function($credit){
            if(isset($credit['release_date'])){
                $releaseDate = $credit['release_date'];
            }
            elseif(isset($credit['first_air_date'])){
                $releaseDate = $credit['first_air_date'];
            }
            else{
                $releaseDate = '';
            }

            if(isset($credit['title'])){
                $title = $credit['title'];
            }
            elseif(isset($credit['name'])){
                $title = $credit['name'];
            }
            else{
                $title = '';
            }

            return collect($credit)->merge([
                'release_date' => $releaseDate,
                'title' => $title,
                'release_year' => isset($releaseDate) ? Carbon::parse($releaseDate)->format('Y') : 'Future',
                'character' => isset($credit['character']) ? $credit['character'] : '',
            ])->only(
                'id', 'release_date', 'title', 'release_year', 'character'
            );
        })->sortByDesc('release_date');
    }

}
