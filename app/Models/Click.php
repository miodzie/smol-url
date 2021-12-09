<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Click extends Model
{
    use HasFactory;

    /**
     * ShortUrlLogs belong to one ShortUrl.
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tinyURL()
    {
        return $this->belongsTo(App\ShortUrl::class);
    }
}
