<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'winner' => $this->winner,
            'created_at' => Carbon::make($this->created_at)->format('d/m/Y'),
            'updated_at' => Carbon::make($this->updated_at)->format('d/m/Y'),
            'studio' => $this->studios,
            'producer' => $this->producers,
        ];
    }
}
