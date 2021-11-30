<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShortUrlLog extends Model
{
    /**
     * ShortUrlLogs belong to one ShortUrl.
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shortUrl()
    {
        return $this->belongsTo(App\ShortUrl::class);
    }
}
