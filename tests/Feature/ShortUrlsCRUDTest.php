<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\ShortUrl;

class ShortUrlsCRUDTest extends TestCase
{
    use DatabaseMigrations;

    public function test_any_guest_can_view_the_create_page()
    {
        $this->get(route('short-urls.create'))
            ->assertSee('URL:')
            ->assertSee('Go!');
    }

    public function test_any_guest_can_create_a_short_url()
    {
        $shortUrl = ShortUrl::factory()->make();

        $response = $this->followingRedirects()->post(route('short-urls.store'), $shortUrl->toArray());
        $response->assertStatus(200);

        $shortUrl = ShortUrl::whereFullUrl($shortUrl->full_url)->first();
        $response->assertSee($shortUrl->getRedirectURL());
    }

    public function test_any_guest_can_view_a_short_url()
    {
        $shortUrl = ShortUrl::factory()->create();

        $this->get(route('short-urls.show', $shortUrl->id))
            ->assertSee($shortUrl->getRedirectURL());
    }

    public function test_a_short_url_requires_a_full_url()
    {
        $this->createShortUrl(['full_url' => null])
            ->assertSessionHasErrors('full_url');
    }

    private function createShortUrl($overrides = [])
    {
        $shortUrl = ShortUrl::factory()->make($overrides);

        return $this->post(route('short-urls.store'), $shortUrl->toArray());
    }
}
