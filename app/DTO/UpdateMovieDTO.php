<?php

namespace App\DTO;

use App\Http\Requests\StoreUpdateMovieRequest;

class UpdateMovieDTO {
    public function __construct(
        public string $id,
        public string $year,
        public string $title,
        public string $winner
    ) { }

    public static function makeFromRequest(StoreUpdateMovieRequest $request, string $id = null): self {
        return new self(
            $id ?? $request->id,
            $request->year,
            $request->title,
            $request->winner ?? 'no'
        );
    }
}
