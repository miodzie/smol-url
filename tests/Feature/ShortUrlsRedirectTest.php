<?php

namespace Tests\Feature;

use Database\Factories\ShortUrlFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;

class ShortUrlsRedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_retrieve_from_the_cache()
    {
        // Arrange
        $shortUrl = ShortUrlFactory::new()->create();
        $shortUrl->cache();

        // Act
        $response = $this->get($shortUrl->getRedirectURL());

        // Assert
        $response->assertStatus(302);
    }

    public function test_it_caches_on_successful_redirect()
    {
        // Arrange
        $shortUrl = ShortUrlFactory::new()->create();

        // Act
        // Assert
        $this->get($shortUrl->getRedirectURL())
            ->assertStatus(302);
        $this->assertEquals(Cache::get('short_url_' . $shortUrl->token)->token, $shortUrl->token);
    }

    public function test_it_redirects_with_a_valid_token()
    {
        // Arrange
        $expected = 'http://ddg.gg';
        $shortUrl = ShortUrlFactory::new()->create(['full_url' => 'ddg.gg']);

        // Act
        // Assert
        $this->get($shortUrl->getRedirectURL())
            ->assertStatus(302)
            ->assertRedirect($expected);
    }

    public function test_it_doesnt_redirect_with_an_invalid_token()
    {
        // Arrange
        // Act
        // Assert
        $this->get(config('app.url') . '/' . 'randomstring')
            ->assertStatus(422);
    }
}
