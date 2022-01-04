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

    public const ROUTE = '/api/urls';

    public function test_create_a_tiny_url()
    {
        // Arrange
        $turl = TinyUrlFactory::new()->make();

        // Act
        $result = $this->post(self::ROUTE, $turl->toArray());

        // Assert
        $result->assertCreated();

        $turl = TinyUrl::findOrFail($result->json('id'));
        $result->assertJson($turl->toArray());
    }

    public function test_it_prepends_http_if_it_doesnt_exist()
    {
        // Arrange
        $turl = TinyUrlFactory::new()->make(['url' => 'example.com/']);

        // Act
        $result = $this->post(self::ROUTE, ['url' => $turl->url]);

        // Assert
        $result->assertCreated();

        $turl = TinyUrl::findOrFail($result->json('id'));
        $this->assertEquals('http://example.com/', $turl->url);
        /* $result->assertJson($turl->toArray()); */
    }
}
