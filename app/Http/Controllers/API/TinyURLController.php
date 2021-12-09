<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TinyUrl;

class TinyUrlController extends Controller
{
    public function all()
    {
        return TinyUrl::all();
    }

    public function store()
    {
    }
}
