<?php

namespace App\Repositories\Contracts;

use App\DTO\CreateMovieDTO;
use App\DTO\UpdateMovieDTO;
use App\Models\Movie;

use stdClass;

interface MovieRepositoryInterface {
    public function paginate(int $page = 1, int $totalPerPage = 15, string $filter = null): PaginationInterface;
    public function getAll(string $filter = null): array;
    public function findOne(string $id): stdClass|null;
    public function delete(string $id): void;
    public function new(CreateMovieDTO $dto): Movie;
    public function update(UpdateMovieDTO $dto): stdClass|null;
    public function award(): stdClass;
}
