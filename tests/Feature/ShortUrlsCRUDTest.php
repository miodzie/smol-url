<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\ShortUrl;

class ShortUrlsCRUDTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function any_guest_can_view_the_create_page()
    {
        $this->get(route('short-urls.create'))
            ->assertSee('URL:')
            ->assertSee('Go!');
    }

    /** @test */
    public function any_guest_can_create_a_short_url()
    {
        $shortUrl = factory('App\ShortUrl')->make();

        $response = $this->followingRedirects()->post(route('short-urls.store'), $shortUrl->toArray());
        $response->assertStatus(200);

        $shortUrl = ShortUrl::whereFullUrl($shortUrl->full_url)->first();
        $response->assertSee($shortUrl->getLink());
    }

    /** @test */
    public function any_guest_can_view_a_short_url()
    {
        $shortUrl = factory('App\ShortUrl')->create();

        $this->get(route('short-urls.show', $shortUrl->id))
            ->assertSee($shortUrl->getLink());
    }

    /** @test */
    public function a_short_url_requires_a_full_url()
    {
        $this->createShortUrl(['full_url' => null])
            ->assertSessionHasErrors('full_url');
    }

    private function createShortUrl($overrides = [])
    {
        $shortUrl = factory('App\ShortUrl')->make($overrides);

        return $this->post(route('short-urls.store'), $shortUrl->toArray());
    }
}
