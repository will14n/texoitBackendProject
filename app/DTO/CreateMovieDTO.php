<?php

namespace App\DTO;

use App\Http\Requests\StoreUpdateMovieRequest;
use stdClass;

class CreateMovieDTO {
    public function __construct(
        public int $year,
        public string $title,
        public string $winner = 'no'
    ) { }

    public static function makeFromRequest(StoreUpdateMovieRequest $request): self {
        return new self(
            $request->year,
            $request->title,
            $request->winner ?? 'no'
        );
    }

    public static function makeFromCSV(stdClass $request): self {
        return new self(
            $request->year,
            $request->title,
            $request->winner ?? 'no'
        );
    }
}
