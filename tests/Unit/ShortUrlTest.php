<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\TinyUrl;
use Database\Factories\ShortUrlFactory;
use Database\Factories\ShortUrlLogFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShortUrlTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_cache_itself()
    {
        $shortUrl = TinyUrl::factory()->make();
        $shortUrl->cache();
        $this->assertEquals(TinyUrl::fromCache($shortUrl->token), $shortUrl);
    }

    public function test_it_has_many_short_url_logs()
    {
        $shortUrl = TinyUrl::factory()->create();
        $logs = ShortUrlLogFactory::times(5)->create(['short_url_id' => $shortUrl->id]);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $shortUrl->logs);

        $this->assertEquals(count($logs), 5);
    }

    public function test_it_can_log_a_redirect()
    {
        $shortUrl = ShortUrlFactory::new()->create();
        $log = $shortUrl->logRedirect(request());
        $this->assertEquals($log->short_url_id, $shortUrl->id);
        $this->assertEquals($log->ip_address, request()->ip());
    }

    public function test_it_creates_a_proper_redirect_url()
    {
        $shortUrl = ShortUrlFactory::new()->make();
        $this->assertEquals($shortUrl->getRedirectURL(), config('app.url') . '/' . $shortUrl->token);
    }

    public function test_it_creates_a_unique_token()
    {
        $token = TinyUrl::generateUniqueToken();
        $this->assertTrue(!TinyUrl::whereToken($token)->exists());
    }

    public function test_it_can_generate_a_valid_link_without_a_scheme()
    {
        // Arrange
        $expected = 'http://ddg.gg';
        $shortUrl = ShortUrlFactory::new()->make(['full_url' => 'ddg.gg']);

        // Act
        $url = $shortUrl->getURL();

        // Assert
        $this->assertEquals($expected, $url);
    }

    public function test_it_can_generate_a_valid_link_with_a_custom_port()
    {
        // Arrange
        $expected = 'http://ddg.gg:443/1234';
        $shortUrl = ShortUrlFactory::new()->make(['full_url' => 'ddg.gg:443/1234']);

        // Act
        $url = $shortUrl->getURL();

        // Assert
        $this->assertEquals($expected, $url);
    }

    public function test_it_can_generate_a_valid_link_with_a_custom_query_string()
    {
        // Arrange
        $expected = 'http://ddg.gg:443/1234?s=My%20Search%20String&enabled=true';
        $shortUrl = ShortUrlFactory::new()->make(['full_url' => 'ddg.gg:443/1234?s=My%20Search%20String&enabled=true']);

        // Act
        $url = $shortUrl->getURL();

        // Assert
        $this->assertEquals($expected, $url);
    }

    public function test_it_can_generate_a_valid_link_with_a_host_but_no_port()
    {
        // Arrange
        $expected = 'https://ddg.gg/1234';
        $shortUrl = ShortUrlFactory::new()->make(['full_url' => 'https://ddg.gg/1234']);

        // Act
        $url = $shortUrl->getURL();

        // Assert
        $this->assertEquals($expected, $url);
    }
}
