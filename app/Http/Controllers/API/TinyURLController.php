<?php 
declare(strict_types=1);

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
        $url = $request->input('url');
        // TODO: this is terrible, clean up.
        if(!strpos($url, 'http://')) {
          $request['url'] = "http://{$url}";
        }

        $this->validate($request, 
          ['url' => [
            'required',
            'regex:' . UrlValidator::REGEX
          ]
        ]);

        $tinyUrl = new TinyUrl();
        $tinyUrl->url = $request->url;
        $tinyUrl->token = TinyUrl::generateUniqueToken();
        $tinyUrl->save();

        return JsonResponse::create($tinyUrl->refresh(), Response::HTTP_CREATED);
    }

    public function delete()
    {
    }
}
