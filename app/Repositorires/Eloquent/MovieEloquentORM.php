<?php

namespace App\Repositories\Eloquent;

use App\DTO\{
    CreateMovieDTO,
    UpdateMovieDTO,
};
use App\Models\{
    Movie,
    Producer,
    Studio,
};
use App\Repositories\Contracts\{
    MovieRepositoryInterface,
    PaginationInterface,
    PaginationPresenter,
};
use Illuminate\Support\Facades\DB;
use stdClass;

class MovieEloquentORM implements MovieRepositoryInterface
{

    public function __construct(
        protected Movie $movie,
        protected Producer $producer,
        protected Studio $studio,
    ) { }

    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null): PaginationInterface
    {
        //code...
        $result = $this->movie
        ->where(function ($query) use ($filter) {
            if ($filter) {
                $query->where('title', 'like', "%{$filter}%");
            }
        })
        ->with('producers')
        ->with('studios')
        ->paginate($totalPerPage, ['*'], 'pages', $page);

        return new PaginationPresenter($result);
    }

    public function getAll(string $filter = null): array
    {
        return $this->movie
            ->where(function ($query) use ($filter) {
                if ($filter) {
                    $query->where('title', 'like', "%{$filter}%");
                }
            })
            ->paginate()
            ->toArray();
    }

    public function findOne(string $id): stdClass|null
    {
        $movie = $this->movie->with('producers')->with('studios')->find($id);

        if (!$movie) {
            return null;
        }

        return (object) $movie->toArray();
    }

    public function delete(string $id): void
    {
        $this->movie->findOrFail($id)->delete();
    }

    public function new(CreateMovieDTO $dto): Movie
    {
        $movie = $this->movie->firstOrCreate(
            (array) $dto
        );

        return $movie;
    }

    public function update(UpdateMovieDTO $dto): stdClass|null
    {
        if (!$movie = $this->movie->find($dto->id)) {
            return null;
        }

        $movie->update(
            (array) $dto
        );

        return (object) $movie->toArray();
    }

    public function award(): stdClass
    {
        $movies = DB::table('movies')
            ->join('movie_producer', 'movies.id', '=', 'movie_producer.movie_id')
            ->join('producers', 'movie_producer.producer_id', '=', 'producers.id')
            ->leftJoin('movies AS movies2', function($join) {
                $join->on('movies2.id', '=',
                    DB::raw(
                        "(
                            SELECT movie_producer3.movie_id AS movie4
                            FROM movie_producer AS movie_producer3
                            JOIN movies AS movies3 on movie_producer3.movie_id = movies3.id
                            WHERE movie_producer3.producer_id = movie_producer.producer_id
                            AND movie_producer3.movie_id > movie_producer.movie_id
                            AND movies3.winner = 'yes'
                            ORDER BY movies3.year ASC
                            LIMIT 1
                        )"
                    )
                );
            })
            ->select(DB::raw(
                'producers.name AS producer,
                ((movies2.year) - (movies.year)) AS interval,
                movies.year AS previousWin,
                movies2.year AS followingWin'
            ))
            ->where('movies.winner', '=', 'yes')
            ->where('interval', '>', 0)
            ->orderBy('movies.year')
            ->orderBy('interval', 'asc')
            ->get();

        return (object) $movies->toArray();
    }
}
