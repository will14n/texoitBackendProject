<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class MovieAwardResource extends JsonResource
{
    public static $wrap = null;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $awardWinners = (array) $this->resource;
        if($this->whenNotNull($awardWinners)) {

            $producers = array_values(
                Arr::sort(
                    $awardWinners,
                    fn ($value) => $value->interval
                    )
                );

                $min = current($producers)->interval;
                $max = end($producers)->interval;

                return [
                    'min' => [
                    Arr::where($producers, function ($value, $key) use ($min) {
                        return $value->interval == $min;
                    }),
                ],
                'max' => [
                    Arr::where($producers, function ($value, $key) use ($max) {
                        return $value->interval == $max;
                    })
                ],
            ];
        }
        return [
            'min' => '',
            'max' => ''
        ];
    }
}
