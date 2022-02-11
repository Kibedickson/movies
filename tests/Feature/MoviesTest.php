<?php

use Illuminate\Support\Facades\Http;

test('shows correct info on movies page', function () {
    Http::fake([
        'https://api.themoviedb.org/3/movie/popular' => fakePopularMovies(),
        'https://api.themoviedb.org/3/movie/now_playing' => fakeNowPlayingMovies(),
        'https://api.themoviedb.org/3/genre/movie/list' => fakeGenres(),
    ]);

    $response = $this->getJson('/api/movies');

    $response->assertSuccessful();
    $response->assertJsonCount(2);
    $response->assertExactJson([
        "popularMovies" => [
            0 => [
                "id" => 1,
                "title" => "Movie 1",
                "overview" => "Movie 1 overview",
                "poster_path" => "https://image.tmdb.org/t/p/w500/path/to/poster",
                "vote_average" => "60%",
                "release_date" => "Jan 01, 2020",
                "genres" => "Adventure, Action"
            ]
        ],
        "nowPlayingMovies" => [
            0 => [
                "id" => 1,
                "title" => "Now Playing Movie 1",
                "overview" => "Now Playing Movie 1 overview",
                "poster_path" => "https://image.tmdb.org/t/p/w500/path/to/poster",
                "vote_average" => "60%",
                "release_date" => "Jan 01, 2020",
                "genres" => "Adventure, Action"
            ]
        ]

    ]);

});

test('movie page shows correct info', function () {
    Http::fake([
        'https://api.themoviedb.org/3/movie/*' => fakeSingleMovie(),
    ]);

    $response = $this->getJson('/api/movies/*');
    $response->assertSuccessful();
    expect($response['genres'])->toBe("Action, Adventure");
    expect($response['title'])->toBe("Movie 1");
    expect($response['poster_path'])->toBe("https://image.tmdb.org/t/p/w500/path/to/poster");
    expect($response['vote_average'])->toBe("60%");
});

function fakePopularMovies(): \GuzzleHttp\Promise\PromiseInterface
{
    return Http::response([
        'results' => [
            [
                'id' => 1,
                'title' => 'Movie 1',
                'poster_path' => 'path/to/poster',
                'overview' => 'Movie 1 overview',
                'release_date' => '2020-01-01',
                'vote_average' => 6,
                'genre_ids' => [12, 28]
            ],
        ],
    ], 200);
}

function fakeNowPlayingMovies(): \GuzzleHttp\Promise\PromiseInterface
{
    return Http::response([
        'results' => [
            [
                'id' => 1,
                'title' => 'Now Playing Movie 1',
                'poster_path' => 'path/to/poster',
                'overview' => 'Now Playing Movie 1 overview',
                'release_date' => '2020-01-01',
                'vote_average' => 6,
                'genre_ids' => [12, 28]
            ],
        ],
    ], 200);
}

function fakeSingleMovie(): \GuzzleHttp\Promise\PromiseInterface
{
    return Http::response([
        'id' => 1,
        'title' => 'Movie 1',
        'poster_path' => 'path/to/poster',
        'overview' => 'Movie 1 overview',
        'release_date' => '2020-01-01',
        'vote_average' => 6,
        "genres" => [
            ["id" => 28, "name" => "Action"],
            ["id" => 12, "name" => "Adventure"],
        ],
        'credits' => [
            'cast' => [],
            'crew' => [],
        ],
        'videos' => [],
        'images' => [
            'backdrops' => [],
        ],
        'crew' => [],
        'cast' => [],
    ], 200);
}

function fakeGenres(): \GuzzleHttp\Promise\PromiseInterface
{
    return Http::response([
        'genres' => [
            [
                "id" => 28,
                "name" => "Action"
            ],
            [
                "id" => 12,
                "name" => "Adventure"
            ],
            [
                "id" => 16,
                "name" => "Animation"
            ],
            [
                "id" => 35,
                "name" => "Comedy"
            ],
            [
                "id" => 80,
                "name" => "Crime"
            ],
            [
                "id" => 99,
                "name" => "Documentary"
            ],
            [
                "id" => 18,
                "name" => "Drama"
            ],
            [
                "id" => 10751,
                "name" => "Family"
            ],
            [
                "id" => 14,
                "name" => "Fantasy"
            ],
            [
                "id" => 36,
                "name" => "History"
            ],
            [
                "id" => 27,
                "name" => "Horror"
            ],
            [
                "id" => 10402,
                "name" => "Music"
            ],
            [
                "id" => 9648,
                "name" => "Mystery"
            ],
            [
                "id" => 10749,
                "name" => "Romance"
            ],
            [
                "id" => 878,
                "name" => "Science Fiction"
            ],
            [
                "id" => 10770,
                "name" => "TV Movie"
            ],
            [
                "id" => 53,
                "name" => "Thriller"
            ],
            [
                "id" => 10752,
                "name" => "War"
            ],
            [
                "id" => 37,
                "name" => "Western"
            ],
        ]
    ], 200);
}
