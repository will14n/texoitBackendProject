<?php

namespace App\DTO;

use App\Http\Requests\StoreUpdateMovieRequest;

use stdClass;

class CreateProducerDTO {
    public function __construct(
        public array $values
    ) { }

    public static function makeFromRequest(StoreUpdateMovieRequest $request): self {
        $delete = array(', ', ' and ', ' AND ');
        $producers = array_filter(explode($delete[0], str_replace($delete, $delete[0], $request->producers)), 'strlen');

        foreach ($producers as $key => $producerName) {
            $return[] = ['name' => $producerName];
        }

        return new self(
            $return,
        );
    }

    public static function makeFromCSV(stdClass $data): self {
        $delete = array(', ', ' and ', ' AND ');
        $producers = array_filter(explode($delete[0], str_replace($delete, $delete[0], $data->producers)), 'strlen');

        foreach ($producers as $key => $producerName) {
            $return[] = ['name' => $producerName];
        }

        return new self(
            $return,
        );
    }
}
