<?php

namespace App\Repositories\Eloquent;

use App\DTO\CreateStudioDTO;
use App\Models\Studio;
use App\Repositories\Contracts\StudioRepositoryInterface;
use Illuminate\Support\Facades\DB;

use stdClass;

class StudioEloquentORM implements StudioRepositoryInterface
{

    public function __construct(
        protected Studio $model
    ) { }

    public function findOne(string $id): stdClass|null
    {
        $support = $this->model->find($id);
        if (!$support) {
            return null;
        }

        return (object) $support->toArray();
    }

    public function new(CreateStudioDTO $dto): stdClass
    {
        $insertedStudio = [];
        foreach ($dto->values as $key => $stuidoName) {
            $studio = current(DB::select('SELECT id FROM studios WHERE studios.name = "'.current($stuidoName).'" LIMIT 1'));

            if ($studio) {
                $studioId = $studio->id;
            }
            else {
                $studioId = $this->model->create($stuidoName)->id;
            }

            $insertedStudio[] = ['studio_id' => $studioId];
        }
        return (object) $insertedStudio;
    }
}
