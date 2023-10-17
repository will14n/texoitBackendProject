<?php

namespace App\Repositories\Contracts;

use App\DTO\CreateStudioDTO;

use stdClass;

interface StudioRepositoryInterface {
    public function findOne(string $id): stdClass|null;
    public function new(CreateStudioDTO $dto): stdClass;
}
