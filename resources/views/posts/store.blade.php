@extends('layouts.app')

@section('content')

    <div class="container">
        @if (Session::has('actionResponse'))
            @component('components.alert', ['alertType' => Session::get('alertType')])
                @slot('message')
                    {{ Session::get('message') }}
                @endslot
            @endcomponent
        @endif
        <div class="posts">
            <div class="posts-title-block mb-3 d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Posts Store</h3>
                <div class="add-post">
                    <a href="{{ route('posts.create') }}" class="btn btn-primary">Add a post</a>
                </div>
            </div>
            @foreach ($posts as $post)
                <div class="post mb-2">
                    <div class="card">
                        <div class="card-body d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">{{ $post->title }}</h5>
                            <div class="actions">
                                <a href="{{ route('posts.view', ['id' => $post->id]) }}" class="btn btn-sm btn-primary">View</a>
                                @can('edit-post', $post)
                                    <a href="{{ route('posts.edit', ['id' => $post->id]) }}" class="btn btn-sm btn-success">Edit</a>
                                @endcan
                                @can('delete-post', $post)
                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger mr-auto delete-post-btn" data-toggle="modal"
                                        data-target="#deletePostModal" data-id="{{ $post->id }}">Delete</a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @component('components.modal-delete', ['id' => 'deletePostModal'])
        @slot('question')
            Are you sure you want to delete this post?
        @endslot
    @endcomponent
@endsection
