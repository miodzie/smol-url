@extends('layouts.app')
@section('content') 
        <div class="container">
            <a href="{{$shortUrl->getLink()}}" _target="blank">{{$shortUrl->getLink()}}</a>
        </div>
@endsection
