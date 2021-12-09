<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Models\TinyUrl;

class TinyUrlsCRUDTest extends TestCase
{
    use DatabaseMigrations;

    public function test_any_guest_can_view_the_create_page()
    {
        $this->get(route('tiny-urls.create'))
            ->assertSee('URL:')
            ->assertSee('Go!');
    }

    public function test_any_guest_can_create_a_tiny_url()
    {
        // Arrange
        $tinyUrl = TinyUrl::factory()->make();

        // Act
        $response = $this->followingRedirects()->post(route('tiny-urls.store'), $tinyUrl->toArray());

        // Assert
        $response->assertStatus(200);
        $tinyUrl = TinyUrl::whereFullUrl($tinyUrl->full_url)->first();
        $response->assertSee($tinyUrl->getRedirectURL());
    }

    public function test_any_guest_can_view_a_tiny_url()
    {
        // Arrange
        $tinyUrl = TinyUrl::factory()->create();

        // Act
        // Assert
        $this->get(route('tiny-urls.show', $tinyUrl->id))
            ->assertSee($tinyUrl->getRedirectURL());
    }

    public function test_a_tiny_url_requires_a_full_url()
    {
        $this->createTinyUrl(['full_url' => null])
            ->assertSessionHasErrors('full_url');
    }

    private function createTinyUrl($overrides = [])
    {
        $tinyUrl = TinyUrl::factory()->make($overrides);

        return $this->post(route('tiny-urls.store'), $tinyUrl->toArray());
    }
}
