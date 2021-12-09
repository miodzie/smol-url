@extends('layouts.app')
@section('content')
    <form action="{{route('tiny-urls.store')}}" method="POST">
        @csrf
        <div class="container">
            <div class="input-group mb-3">
                <div class="input-group input-group-lg">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="inputGroup-sizing-lg">URL:</span>
                    </div>
                    <input name="full_url" type="text" class="form-control" aria-label="Large" aria-describedby="inputGroup-sizing-sm">
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-lg">Go!</button>
        </div>

    </form>
@endsection
