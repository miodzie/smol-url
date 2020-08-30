<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\ShortUrl;

class ShortUrlTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function it_can_cache_itself()
    {
        $shortUrl = factory('App\ShortUrl')->create();
        $shortUrl->cache();
        $this->assertEquals(ShortUrl::fromCache($shortUrl->token), $shortUrl);
    }

    /** @test */
    public function it_has_many_short_url_logs()
    {
        $shortUrl = factory('App\ShortUrl')->create();
        $logs = factory('App\ShortUrlLog', 5)->create(['short_url_id' => $shortUrl->id]);
        
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $shortUrl->logs);

        $this->assertEquals(count($logs), 5);
    }

    /** @test */
    public function it_can_log_a_redirect()
    {
        $shortUrl = factory('App\ShortUrl')->create();
        $log = $shortUrl->logRedirect(request());
        $this->assertEquals($log->short_url_id, $shortUrl->id);
        $this->assertEquals($log->ip_address, request()->ip());
    }

    /** @test */
    public function it_creates_a_proper_redirect_link()
    {
        $shortUrl = factory('App\ShortUrl')->create();
        $this->assertEquals($shortUrl->getLink(), config('app.url') . '/' . $shortUrl->token);
    }

    /** @test */
    public function it_creates_a_unique_token()
    {
        $token = ShortUrl::generateUniqueToken();
        $this->assertTrue(! ShortUrl::whereToken($token)->exists());
    }
}
