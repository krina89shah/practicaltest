@extends('layouts.app')

@section('content')
    <h1>Comments on "{{ $post->title }}"</h1>
    <ul>
        @foreach ($comments as $comment)
            <li>
                <strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}
            </li>
        @endforeach
    </ul>
@endsection
