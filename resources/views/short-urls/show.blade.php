@extends('layouts.app')
@section('content')
        <div class="container">
            <a href="{{$shortUrl->getRedirectURL()}}" _target="blank">{{$shortUrl->getRedirectURL()}}</a>
        </div>
@endsection
