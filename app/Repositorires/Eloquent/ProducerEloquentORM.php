<?php

namespace App\Repositories\Eloquent;

use App\DTO\CreateProducerDTO;
use App\DTO\UpdateProducerDTO;
use App\Models\Producer;
use App\Repositories\Contracts\ProducerRepositoryInterface;
use Illuminate\Support\Facades\DB;

use stdClass;

class ProducerEloquentORM implements ProducerRepositoryInterface
{

    public function __construct(
        protected Producer $model
    ) { }

    public function findOne(string $id): stdClass|null
    {
        $support = $this->model->find($id);
        if (!$support) {
            return null;
        }

        return (object) $support->toArray();
    }

    public function new(CreateProducerDTO $dto): stdClass
    {
        $insertedProducer=[];
        foreach ($dto->values as $key => $producerName) {
            $producer = current(DB::select('SELECT id FROM producers WHERE producers.name = "'.current($producerName).'" LIMIT 1'));

            if ($producer) {
                $producerId = $producer->id;
            }
            else {
                $producerId = $this->model->create($producerName)->id;
            }

            $insertedProducer[] = ['producer_id' => $producerId];
        }
        return (object) $insertedProducer;
    }
}
