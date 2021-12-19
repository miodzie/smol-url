<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TinyUrl;
use App\TinyUrls\UrlValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TinyUrlController extends Controller
{
    public function all()
    {
        return TinyUrl::all();
    }

    public function store(Request $request)
    {
        $this->validate($request, ['full_url' => [
            'required',
            'regex:' . UrlValidator::REGEX
        ]]);

        $tinyUrl = new TinyUrl;
        $tinyUrl->full_url = $request->full_url;
        $tinyUrl->token = TinyUrl::generateUniqueToken();
        $tinyUrl->save();

        return JsonResponse::create($tinyUrl, Response::HTTP_CREATED);
    }

    public function delete()
    {
    }
}
