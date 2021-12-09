<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Click extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * ShortUrlLogs belong to one ShortUrl.
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tinyUrl()
    {
        return $this->belongsTo(TinyUrl::class);
    }
}
