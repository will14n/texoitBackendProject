<?php

namespace App\DTO;

use App\Http\Requests\StoreUpdateMovieRequest;
use stdClass;

class CreateStudioDTO {
    public function __construct(
        public array $values
    ) { }

    public static function makeFromRequest(StoreUpdateMovieRequest $request): self {
        $delete = array(', ', 'and', 'AND');
        $studios = explode($delete[0], str_replace($delete, $delete[0], $request->studios));

        foreach ($studios as $key => $studioName) {
            $return[] = ['name' => $studioName];
        }

        return new self(
            $return
        );
    }

    public static function makeFromCSV(stdClass $data): self {
        $delete = array(', ', 'and', 'AND');
        $studios = explode($delete[0], str_replace($delete, $delete[0], $data->studios));

        foreach ($studios as $key => $studioName) {
            $return[] = ['name' => $studioName];
        }

        return new self(
            $return,
        );
    }
}
