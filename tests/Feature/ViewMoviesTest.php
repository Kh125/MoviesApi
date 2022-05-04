<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ViewMoviesTest extends TestCase
{
    /** @test */
    public function the_main_page_shows_correct_info()
    {
        Http::fake([
            'https://api.themoviedb.org/3/movie/popular' => $this->fakePopularMovies(),
            'https://api.themoviedb.org/3/movie/now_playing' => $this->fakeNowPlayingMovies(),
            'https://api.themoviedb.org/3/genre/movie/list' => $this->fakeGenres(),
        ]); 
        $response = $this->get(route('movies.index'));
        $response->assertSuccessful();
        $response->assertSee('Popular Movies');
        $response->assertSee('Spider-Man: No Way Home');        
        // $response->assertSee('Action, Adventure, Science Fiction');
        $response->assertSee('Now Playing');
        $response->assertSee('Spider-Man: No Way Home');            
    }

    private function fakePopularMovies(){
        return Http::response([
            'results' => [
                [
                    "adult" => false,
                    "backdrop_path" => "/1Rr5SrvHxMXHu5RjKpaMba8VTzi.jpg",
                    "genre_ids" => [
                      0 => 28,
                      1 => 12,
                      2 => 878,
                    ],
                    "id" => 634649,
                    "original_language" => "en",
                    "original_title" => "Spider-Man: No Way Home",
                    "overview" => "Peter Parker is unmasked and no longer able to separate his normal life from the high-stakes of being a super-hero. When he asks for help from Doctor Strange the stakes become even more dangerous, forcing him to discover what it truly means to be Spider-Man.",
                    "popularity" => 8745.819,
                    "poster_path" => "/1g0dhYtq4irTY1GPXvft6k4YLjm.jpg",
                    "release_date" => "2021-12-15",
                    "title" => "Spider-Man: No Way Home",
                    "video" => false,
                    "vote_average" => 8.4,
                    "vote_count" => 3811,
                  ]
            ]
        ], 200);
    }

    private function fakeNowPlayingMovies(){
        return Http::response([
            'results' => [
                [
                    "adult" => false,
                    "backdrop_path" => "/1Rr5SrvHxMXHu5RjKpaMba8VTzi.jpg",
                    "genre_ids" => [
                      0 => 28,
                      1 => 12,
                      2 => 878,
                    ],
                    "id" => 634649,
                    "original_language" => "en",
                    "original_title" => "Spider-Man: No Way Home",
                    "overview" => "Peter Parker is unmasked and no longer able to separate his normal life from the high-stakes of being a super-hero. When he asks for help from Doctor Strange the stakes become even more dangerous, forcing him to discover what it truly means to be Spider-Man.",
                    "popularity" => 8745.819,
                    "poster_path" => "/1g0dhYtq4irTY1GPXvft6k4YLjm.jpg",
                    "release_date" => "2021-12-15",
                    "title" => "Spider-Man: No Way Home",
                    "video" => false,
                    "vote_average" => 8.4,
                    "vote_count" => 3811,
                  ]
            ]
        ], 200);
    }

    private function fakeGenres(){
        return Http::response([
            'genres' => [
                0 => [
                    "id" => 28,
                    "name" => "Action"
                ]
            ]
        ], 200);
    }

}


