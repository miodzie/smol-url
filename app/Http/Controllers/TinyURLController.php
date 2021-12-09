<?php

namespace App\Http\Controllers;

use App\Models\TinyUrl;
use Illuminate\Http\Request;

class TinyUrlController extends Controller
{
    public function create()
    {
        return view('tiny-urls.create');
    }

    public function store(Request $request)
    {
        // Regex "borrowed" from
        // @see https://laracasts.com/discuss/channels/general-discussion/url-validation
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';
        $this->validate($request, ['full_url' => 'required|regex:' . $regex]);

        $tinyUrl = new TinyUrl;
        $tinyUrl->full_url = $request->full_url;
        $tinyUrl->token = TinyUrl::generateUniqueToken();
        $tinyUrl->save();

        return redirect(route('tiny-urls.show', $tinyUrl->id));
    }

    public function show(TinyUrl $tinyUrl)
    {
        return view('tiny-urls.show', ['redirectUrl' => $tinyUrl->getRedirectURL(),]);
    }
}
