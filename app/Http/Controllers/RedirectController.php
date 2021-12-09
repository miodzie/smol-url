<?php

namespace App\Http\Controllers;

use App\Models\TinyUrl;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    // TODO: Abstract to RedirectRequester Interface.
    public function redirect(Request $request)
    {
        $token = substr($request->getPathInfo(), 1);

        if (!($shortUrl = TinyUrl::fromCache($token))) {
            // TODO: Replace with Repository so I can mock this call.
            $shortUrl = TinyUrl::whereToken($token)->first();
        }

        if (!$shortUrl) {
            abort(422, "Invalid token");
        }

        // TODO: Try, catch, and still redirect even on failure.
        $shortUrl->logRedirect($request);
        $shortUrl->cache();

        return redirect($shortUrl->getURL());
    }
}
