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
