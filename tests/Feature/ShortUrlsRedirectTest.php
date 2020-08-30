<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Cache;

class ShortUrlsRedirectTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_caches_on_successful_redirect()
    {
        $shortUrl = factory('App\ShortUrl')->create();

        $this->get($shortUrl->getLink())
            ->assertStatus(302);
        $this->assertEquals(Cache::get('short_url_' . $shortUrl->token)->token, $shortUrl->token);
    }

    /** @test */
    public function it_redirects_with_a_valid_token()
    {
        $shortUrl = factory('App\ShortUrl')->create();

        $this->assertEquals($shortUrl->getLink(), config('app.url') . '/' . $shortUrl->token);

        $this->get($shortUrl->getLink())
            ->assertStatus(302);
    }

    /** @test */
    public function it_doesnt_redirect_with_an_invalid_token()
    {
        $this->get(config('app.url') . '/' . 'randomstring')
            ->assertStatus(422);
    }
}
