@extends('layouts.app')

@section('content')
    <div class="container">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <a href="{{ route('posts.store') }}">Posts</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Create
                </li>
            </ol>
        </nav>
        <div class="post-create-container">
            <form method="post" action="{{ route('posts.save') }}" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" 
                        id="title" name="title" aria-describedby="titleHelp" placeholder="Enter a title"
                        value="{{ old('title') }}">
                    @if($errors->has('title'))
                        <div class="invalid-feedback">
                            {{ $errors->first('title') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="category">Select a category</label>
                    <select class="form-control {{ $errors->has('category_id') ? 'is-invalid' : '' }}" id="category" name="category_id">
                        <option value="">Choose a category</option>
                        @foreach ($categories as $category)
                            @if(old('category_id') == $category->id)
                                <option selected value="{{ $category->id }}">{{ $category->name }}</option>
                            @else
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    @if($errors->has('category_id'))
                        <div class="invalid-feedback">
                            {{ $errors->first('category_id') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="text">Text</label>
                    <textarea class="form-control {{ $errors->has('text') ? 'is-invalid' : '' }}" 
                        id="text" name="text" rows="10">{{ old('text') }}</textarea>
                    @if($errors->has('text'))
                        <div class="invalid-feedback">
                            {{ $errors->first('text') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label>Image</label><br>
                    <input type="file" id="img" name="img" class="{{ $errors->has('img') ? 'invalid-file' : '' }}">
                    @if($errors->has('img'))
                        <div class="invalid-feedback">
                            {{ $errors->first('img') }}
                        </div>
                    @endif
                </div>
                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                @csrf
                <button type="submit" class="btn btn-success">Save</button>
                <a href="{{ route('posts.store') }}" class="btn btn-primary">Cancel</a>
            </form>
        </div>
    </div>
@endsection