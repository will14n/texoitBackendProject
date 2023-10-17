<?php

namespace Tests\Integration;

use Tests\TestCase;

class DestroyTest extends TestCase {
    public function test_with_a_invalid_id_param(): void
    {
        $response = $this->json('DELETE', '/api/movies/99999999999999999');

        $response
            ->assertStatus(404)
            ->assertJsonStructure([
                'error',
            ])
            ->assertJson([
                'error' => 'Not Found'
            ]);
    }
}
