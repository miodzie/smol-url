<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Click extends Model
{
    use HasFactory, SoftDeletes;

    public function tinyUrl()
    {
        return $this->belongsTo(TinyUrl::class);
    }
}
