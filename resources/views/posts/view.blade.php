@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="{{ route('posts.store') }}">Posts</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    View
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $post->title }}
                </li>
            </ol>
        </nav>
        <div class="view-container">
            <h4>{{ $post->title }} </h4>
            <div class="text mb-4">
                {{ $post->text }}
            </div>
            <div class="image mb-4">
                <img src="{{ asset('storage/images/'.$post->image->name) }}" alt="">
            </div>
            <div class="post-info">
                <p class="author mb-0"><span class="font-weight-bold">Author:</span> {{ $post->user->name }}</p>
                <p class="published-at mb-0"><span class="font-weight-bold">Published at:</span> {{ date('d.m.Y H:i:s', strtotime($post->created_at)) }}</p>
                <p class="category mb-0"><span class="font-weight-bold">Category:</span> {{ $post->category->name }}</p>
            </div>
        </div>
    </div>
@endsection
