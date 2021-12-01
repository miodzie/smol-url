<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\ShortUrl;
use Database\Factories\ShortUrlFactory;
use Database\Factories\ShortUrlLogFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShortUrlTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_can_cache_itself()
    {
        $shortUrl = ShortUrl::factory()->make();
        $shortUrl->cache();
        $this->assertEquals(ShortUrl::fromCache($shortUrl->token), $shortUrl);
    }

    public function test_it_has_many_short_url_logs()
    {
        $shortUrl = ShortUrl::factory()->create();
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

    public function test_it_creates_a_proper_redirect_link()
    {
        $shortUrl = ShortUrlFactory::new()->make();
        $this->assertEquals($shortUrl->getLink(), config('app.url') . '/' . $shortUrl->token);
    }

    public function test_it_creates_a_unique_token()
    {
        $token = ShortUrl::generateUniqueToken();
        $this->assertTrue(!ShortUrl::whereToken($token)->exists());
    }
}
