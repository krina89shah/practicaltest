@extends('layouts.app')

@section('content')
    <h1>Posts by {{ $user->name }}</h1>
    <ul>
        @foreach ($posts as $post)
            <li>
                <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
            </li>
        @endforeach
    </ul>
@endsection
