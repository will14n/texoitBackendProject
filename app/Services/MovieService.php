<?php

namespace App\Services;

use App\DTO\{
    CreateMovieDTO,
    CreateProducerDTO,
    CreateStudioDTO,
    UpdateMovieDTO,
};
use App\Repositories\Contracts\{
    MovieRepositoryInterface,
    ProducerRepositoryInterface,
    StudioRepositoryInterface,
    PaginationInterface,
};
use Illuminate\Support\Facades\DB;

use stdClass;

class MovieService {

    public function __construct(
        protected MovieRepositoryInterface $movieRepository,
        protected ProducerRepositoryInterface $producerRepository,
        protected StudioRepositoryInterface $studioRepository
    ) { }

    public function paginate(
        int $page = 1,
        int $totalPerPage = 15,
        string $filter = null
    ): PaginationInterface {
        return $this->movieRepository->paginate(
            page: $page,
            totalPerPage: $totalPerPage,
            filter: $filter
        );
    }

    public function getAll(string $filter = null): array {
        return $this->movieRepository->getAll($filter);
    }

    public function findOne(string $id): stdClass|null {
        return $this->movieRepository->findOne($id);
    }

    public function new(CreateMovieDTO $movieDTO, CreateProducerDTO $producerDTO, CreateStudioDTO $studioDTO): stdClass {
        $producer = (array) $this->producerRepository->new($producerDTO);
        $studio = (array) $this->studioRepository->new($studioDTO);
        $movie = $this->movieRepository->new($movieDTO);

        $producer = data_fill($producer, '*.movie_id', $movie->id);
        $studio = data_fill($studio, '*.movie_id', $movie->id);

        DB::table('movie_producer')->insert($producer);
        DB::table('movie_studio')->insert($studio);
        // $movie->producers()->attach($producer);
        // $movie->studios()->syncWithoutDetaching($studio);
        $movie = $this->movieRepository->findOne($movie->id);
        return (object) $movie;
    }

    public function update(UpdateMovieDTO $movieDTO): stdClass|null {
        $movie = $this->movieRepository->update($movieDTO);
        $movie = $this->movieRepository->findOne($movie->id);
        return (object) $movie;
    }

    public function delete(string $id): void {
        $this->movieRepository->delete($id);
    }

    public function award(): stdClass {
        return $this->movieRepository->award();
    }
}
