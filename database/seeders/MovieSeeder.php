<?php

namespace Database\Seeders;

use App\DTO\CreateMovieDTO;
use App\DTO\CreateProducerDTO;
use App\DTO\CreateStudioDTO;
use App\Services\MovieService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

use stdClass;

class MovieSeeder extends Seeder
{
    public function __construct(
        protected MovieService $service,
    ) { }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $file = storage_path().'/imports/movielist.csv';
        if (isset($file)) {
            $getColumnNames = true;
            $movieColumn = [];
            $request = new stdClass();
            if ($handle = fopen($file, 'r')) {
                while(($data = fgetcsv($handle, 1000, ';')) !== FALSE) {
                    if ($getColumnNames) {
                        $movieColumn[$data[0]] = 0;
                        $movieColumn[$data[1]] = 1;
                        $movieColumn[$data[2]] = 2;
                        $movieColumn[$data[3]] = 3;
                        $movieColumn[$data[4]] = 4;
                        $getColumnNames = !$getColumnNames;
                        continue;
                    }

                    $request->year = $data[$movieColumn['year']];
                    $request->title = $data[$movieColumn['title']];
                    $request->studios = $data[$movieColumn['studios']];
                    $request->producers = $data[$movieColumn['producers']];
                    $request->winner = $data[$movieColumn['winner']];

                    $movie = $this->service->new(
                        CreateMovieDTO::makeFromCSV($request),
                        CreateProducerDTO::makeFromCSV($request),
                        CreateStudioDTO::makeFromCSV($request)
                    );
                }
            }
        }
    }
}
