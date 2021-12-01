<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ShortUrlLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * @var integer $id
 * @var string $full_url
 * @var string $token
 * @var Carbon $created_at
 * @var Carbon $updated_at
 */
class ShortUrl extends Model
{
    use HasFactory;

    /**
     * Cache the ShortUrl.
     * @return bool
     */
    public function cache($expiresIn = 1200): bool
    {
        return Cache::put('short_url_' . $this->token, $this, $expiresIn);
    }

    /**
     * Get a ShortUrl if it's cached.
     * @return ShortUrl
     */
    public static function fromCache($token): ?ShortUrl
    {
        return Cache::get('short_url_' . $token);
    }

    /**
     * Create the shortened url.
     * @return string
     */
    public function getRedirectURL(): string
    {
        return config('app.url') . "/" . $this->token;
    }

    // TODO: Abstract to URLGenerator class.
    public function getURL(): string
    {
        $url = parse_url($this->full_url);
        $final = '';

        if (!array_key_exists('scheme', $url)) {
            $url['scheme'] = 'http';
        }
        $final .= "{$url['scheme']}://";


        if (array_key_exists('host', $url)) {
            $final .= $url['host'];
        }

        if (array_key_exists('port', $url)) {
            $final .= ":{$url['port']}";
        }

        $final .= "{$url['path']}";

        if (array_key_exists('query', $url)) {
            $final .= "?{$url['query']}";
        }

        return  $final;
    }


    /**
     * Log a ShortUrl redirect.
     * @return ShortUrlLog
     */
    public function logRedirect(Request $request): ShortUrlLog
    {
        $log = new ShortUrlLog;
        $log->ip_address = $request->ip();
        $log->short_url_id = $this->id;
        $log->save();

        return $log;
    }

    /**
     * Generates a unique token for a ShortUrl.
     * @return string
     */
    public static function generateUniqueToken(): string
    {
        $token = Str::random(rand(6, 20));
        // TODO: This is probably not scalable and/or for big data sets, for low traffic it's likely
        // fine.
        while (ShortUrl::whereToken($token)->exists()) {
            $token = Str::random(rand(6, 20));
        }

        return $token;
    }

    /**
     * ShortUrls have many ShortUrlLogs.
     * @return Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs()
    {
        return $this->hasMany(ShortUrlLog::class);
    }
}
