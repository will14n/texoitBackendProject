<?php

namespace Tests\Integration;

use Tests\TestCase;

class IndexTest extends TestCase {
    public function test_with_page_param(): void
    {
        $response = $this->json('GET', '/api/movies?page=2');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'meta' => [
                    'total',
                    'is_first_page',
                    'is_last_page',
                    'current_page',
                    'next_page',
                    'previous_page',
                ]
            ])
            ->assertJson([
                'meta' => [
                    'current_page' => 2
                ],
            ]);
    }

    public function test_with_per_page_param(): void
    {
        $response = $this->json('GET', '/api/movies?per_page=2');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'meta' => [
                    'total',
                    'is_first_page',
                    'is_last_page',
                    'current_page',
                    'next_page',
                    'previous_page',
                ]
            ]);
    }

    public function test_with_filter_param(): void
    {
        $response = $this->json('GET', '/api/movies?filter=Pearl%Harbor');

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'meta' => [
                    'total',
                    'is_first_page',
                    'is_last_page',
                    'current_page',
                    'next_page',
                    'previous_page',
                ]
            ]);
    }
}
