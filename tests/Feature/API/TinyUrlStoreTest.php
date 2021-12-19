<?php

namespace Tests\Feature\API;

use App\Models\TinyUrl;
use Database\Factories\TinyUrlFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;

class TinyUrlStoreTest extends TestCase
{
    use RefreshDatabase;

    public const ROUTE = '/api/tiny-url';

    public function test_create_a_tiny_url()
    {
        // Arrange
        $turl = TinyUrlFactory::new()->make();

        // Act
        $result = $this->post(self::ROUTE, $turl->toArray());
        $turl = TinyUrl::findOrFail($result->json('id'));

        // Assert
        $result->assertCreated();

        $result->assertJson($turl->toArray());
    }
}
