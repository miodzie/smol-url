<?php

namespace App\Http\Controllers;

use App\Models\TinyUrl;
use Illuminate\Http\Request;

class TinyURLController extends Controller
{

    /**
     * Find a ShortUrl and redirect if it exists.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function findAndRedirect(Request $request)
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

        $shortUrl = new TinyUrl;
        $shortUrl->full_url = $request->full_url;
        $shortUrl->token = TinyUrl::generateUniqueToken();
        $shortUrl->save();

        return redirect(route('short-urls.show', $shortUrl->id));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ShortUrl  $shortUrl
     * @return \Illuminate\Http\Response
     */
    public function show(TinyUrl $shortUrl)
    {
        return view('short-urls.show', compact('shortUrl'));
    }
}
