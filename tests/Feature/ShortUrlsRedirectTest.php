<?php

namespace Tests\Feature;

use Database\Factories\ShortUrlFactory;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;

class ShortUrlsRedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_test_it_caches_on_successful_redirect()
    {
        $shortUrl = ShortUrlFactory::new()->create();

        $this->get($shortUrl->getLink())
            ->assertStatus(302);
        $this->assertEquals(Cache::get('short_url_' . $shortUrl->token)->token, $shortUrl->token);
    }

    public function test_it_redirects_with_a_valid_token()
    {
        $shortUrl = ShortUrlFactory::new()->create();

        $this->assertEquals($shortUrl->getLink(), config('app.url') . '/' . $shortUrl->token);

        $this->get($shortUrl->getLink())
            ->assertStatus(302);
    }

    public function test_it_doesnt_redirect_with_an_invalid_token()
    {
        $this->get(config('app.url') . '/' . 'randomstring')
            ->assertStatus(422);
    }
}
