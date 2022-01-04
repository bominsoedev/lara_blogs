@extends('layouts.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        {{ $post->title }}
                    </div>
                    <div class="card-body">

                        {{ $post->description }}

                        <hr>
                        <a href="{{ route('post.index') }}" class="btn btn-primary">Read All</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
