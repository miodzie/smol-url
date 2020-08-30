<?php

namespace App\Http\Controllers;

use App\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class ShortUrlController extends Controller
{

    /**
     * Find a ShortUrl and redirect if it exists.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function findAndRedirect(Request $request)
    {
        $token = substr($request->getPathInfo(), 1);
        $shortUrl = ShortUrl::fromCache($token);

        if (! $shortUrl) {
            $shortUrl = ShortUrl::whereToken($token)->first();
        }

        if (! $shortUrl) {
            abort(422, "Invalid token");
        }

        $shortUrl->logRedirect($request);
        $shortUrl->cache();

        return redirect($shortUrl->full_url);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('short-urls.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Regex "borrowed" from
        // @see https://laracasts.com/discuss/channels/general-discussion/url-validation
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        $this->validate($request, ['full_url' => 'required|regex:' . $regex]);

        $shortUrl = new ShortUrl;
        $shortUrl->full_url = $request->full_url;
        $shortUrl->token = ShortUrl::generateUniqueToken();
        $shortUrl->save();

        return redirect(route('short-urls.show', $shortUrl->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ShortUrl  $shortUrl
     * @return \Illuminate\Http\Response
     */
    public function show(ShortUrl $shortUrl)
    {
        return view('short-urls.show', compact('shortUrl'));
    }
}
