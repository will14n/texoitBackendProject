<?php

namespace App\Repositories\Contracts;

use App\DTO\CreateProducerDTO;

use stdClass;

interface ProducerRepositoryInterface {
    public function findOne(string $id): stdClass|null;
    public function new(CreateProducerDTO $dto): stdClass;
}
