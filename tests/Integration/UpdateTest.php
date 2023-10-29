<?php

namespace Tests\Integration;

use App\Models\Movie;
use Tests\TestCase;

class UpdateTest extends TestCase
{
    public function test_validation_error_if_title_is_empty(): void
    {
        $movie = Movie::create([
            'title' => 'Filme Desconhecido',
            'year' => 1994,
            'studios' => 'Studio de teste para teste',
            'producers' => 'Produtor de teste para teste',
            'winner' => '',
        ]);

        $response = $this->json('PUT', "/api/movies/$movie->id", [
            'year' => 1994,
            'studios' => 'Studio 2.0 produz todos os filmes',
            'producers' => 'Produtor antigo',
            'winner' => '',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors'
            ])
            ->assertJson([
                'message' => "Movie title is required!",
                'errors' => [
                    'title' => [
                        'Movie title is required!'
                    ]
                ],
            ]);
    }

    public function test_validation_error_if_year_is_bigger_than_4_cracaters(): void
    {
        $movie = Movie::create([
            'title' => 'Filme Desconhecido',
            'year' => 19949,
            'studios' => 'Studio de teste para teste',
            'producers' => 'Produtor de teste para teste',
            'winner' => '',
        ]);

        $payload = [
            'title' => 'Filme Desconhecido2',
            'year' => 19955,
            'studios' => 'Studio de teste para teste2',
            'producers' => 'Produtor de teste para teste2',
            'winner' => '',
        ];

        $response = $this->json('PUT', "/api/movies/$movie->id", $payload);

        $response
            ->assertStatus(422)
            ->assertJson([
                'message' => 'Your "year" is too long!',
                'errors' => [
                    'year' => [
                        'Your "year" is too long!'
                    ]
                ],
            ]);
    }

    public function test_validation_error_if_year_is_shorter_than_4_cracaters(): void
    {
        $movie = Movie::create([
            'title' => 'Filme Desconhecido',
            'year' => 1994,
            'studios' => 'Studio de teste para teste',
            'producers' => 'Produtor de teste para teste',
            'winner' => '',
        ]);

        $payload = [
            'title' => 'Filme Desconhecido2',
            'year' => 195,
            'studios' => 'Studio de teste para teste2',
            'producers' => 'Produtor de teste para teste2',
            'winner' => '',
        ];

        $response = $this->json('PUT', "/api/movies/$movie->id", $payload);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors'
            ])
            ->assertJson([
                'message' => 'Your "year" is too short!',
                'errors' => [
                    'year' => [
                        'Your "year" is too short!'
                    ]
                ],
            ]);
    }

    public function test_validation_error_if_year_is_empty(): void
    {
        $movie = Movie::create([
            'title' => 'Filme Desconhecido',
            'year' => 1994,
            'studios' => 'Studio de teste para teste',
            'producers' => 'Produtor de teste para teste',
            'winner' => '',
        ]);

        $payload = [
            'title' => 'Filme Desconhecido2',
            'year' => 195,
            'studios' => 'Studio de teste para teste2',
            'producers' => 'Produtor de teste para teste2',
            'winner' => '',
        ];

        $response = $this->json('PUT', "/api/movies/$movie->id", $payload);

        $response = $this->json('POST', '/api/movies', [
            'title' => 'Teste de teste sem ano =D',
            'studios' => 'Studio de teste para teste',
            'producers' => 'Produtor de teste para teste',
            'winner' => '',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors'
            ])
            ->assertJson([
                'message' => "Year is required!",
                'errors' => [
                    'year' => [
                        'Year is required!'
                    ]
                ],
            ]);
    }

    public function test_validation_error_if_producer_is_empty(): void
    {
        $movie = Movie::create([
            'title' => 'Filme Desconhecido',
            'year' => 1994,
            'studios' => 'Studio de teste para teste',
            'producers' => 'Produtor de teste para teste',
            'winner' => '',
        ]);

        $payload = [
            'title' => 'Filme Desconhecido2',
            'year' => 195,
            'studios' => 'Studio de teste para teste2',
            'producers' => 'Produtor de teste para teste2',
            'winner' => '',
        ];

        $response = $this->json('PUT', "/api/movies/$movie->id", $payload);

        $response = $this->json('POST', '/api/movies', [
            'title' => 'Teste de teste sem ano =D',
            'year' => 1984,
            'studios' => 'Studio de teste para teste',
            'winner' => '',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors'
            ])
            ->assertJson([
                'message' => "Producer is required!",
                'errors' => [
                    'producers' => [
                        'Producer is required!'
                    ]
                ],
            ]);
    }

    public function test_validation_error_if_studio_is_empty(): void
    {
        $response = $this->json('POST', '/api/movies', [
            'title' => 'Teste de teste sem ano =D',
            'year' => 1984,
            'producers' => 'Produtor de teste para teste',
            'winner' => '',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors'
            ])
            ->assertJson([
                'message' => "Studio is required!",
                'errors' => [
                    'studios' => [
                        'Studio is required!'
                    ]
                ],
            ]);
    }

    public function test_validation_error_if_studio_producer_title_and_year_is_empty(): void
    {
        $movie = Movie::create([
            'title' => 'Filme Desconhecido',
            'year' => 1994,
            'studios' => 'Studio de teste para teste',
            'producers' => 'Produtor de teste para teste',
            'winner' => '',
        ]);

        $payload = [
            'title' => 'Filme Desconhecido2',
            'year' => 195,
            'studios' => 'Studio de teste para teste2',
            'producers' => 'Produtor de teste para teste2',
            'winner' => '',
        ];

        $response = $this->json('PUT', "/api/movies/$movie->id", $payload);

        $response = $this->json('POST', '/api/movies', [
            'winner' => '',
        ]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors'
            ])
            ->assertJson([
                'message' => "Year is required! (and 3 more errors)",
                'errors' => [
                    "year" => [
                        "Year is required!"
                    ],
                    "title" => [
                        "Movie title is required!"
                    ],
                    "studios" => [
                        "Studio is required!"
                    ],
                    "producers" => [
                        "Producer is required!"
                    ]
                ],
            ]);
    }

    public function test_store_with_all_params_and_single_studio_and_producer_params(): void
    {
        $movie = Movie::create([
            'title' => 'Filme Desconhecido',
            'year' => 1994,
            'studios' => 'Studio de teste para teste',
            'producers' => 'Produtor de teste para teste',
            'winner' => '',
        ]);

        $payload = [
            'title' => 'Filme Desconhecido2',
            'year' => 1995,
            'studios' => 'Studio de teste para teste2',
            'producers' => 'Produtor de teste para teste2',
            'winner' => '',
        ];

        $response = $this->json('PUT', "/api/movies/$movie->id", $payload);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'title',
                    'winner',
                    'created_at',
                    'updated_at',
                    'studio' => [

                    ],
                    'producer' => [

                    ]
                ]
            ]);
    }
}
