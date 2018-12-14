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
        <div class="categories-container">
            <h3 class="mb-3">Categories Store</h3>
            <div class="card mb-3 col-lg-5 col-md-6 col-sm-9 px-0">
                <div class="card-body">
                    <p class="h5">Add a category</p>
                    <form method="post" action="{{ route('categories.save') }}" class="add-category d-flex align-items-start">
                        <div class="form-group mb-0 w-100">
                            @csrf
                            <input id="name" name="name" value="{{ old('name') }}" placeholder="Enter a category name" 
                                class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}">
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-success ml-2">Create</button>
                    </form>
                </div>
            </div>
            <ul class="list-group">
                @foreach ($categories as $category)
                    <li class="list-group-item">
                        <div class="category-display {{
                            $errors->has('name_'.$category->id) 
                            || Session::has('name_'.$category->id) ? 'd-none' : 'd-block' }}">
                            <div class="flex-container d-flex justify-content-between align-items-center">
                                <p class="category-name h5 mb-0">{{ $category->name }}</p>
                                <div class="actions">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-primary edit-category-btn">Edit</a>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger mr-auto delete-category-btn" 
                                    data-toggle="modal" data-target="#deleteCategoryModal" data-id="{{ $category->id }}">Delete</a>
                                </div>
                            </div>
                        </div>
                        <form class="edit-category-form {{ 
                                    $errors->has('name_'.$category->id) 
                                    || Session::has('name_'.$category->id)
                                    ? 'd-block' : 'd-none' 
                                }}"
                            method="post" action="{{ route('categories.update', ['id' => $category->id]) }}">
                            <div class="form-container d-flex justify-content-between align-items-center">
                                <div class="form-group mb-0 col-lg-3 col-md-4 col-sm-6 px-0">
                                    @csrf
                                    <input id="name" name="name_{{ $category->id }}" 
                                        value="{{ old('name_'.$category->id) ?? $category->name }}" 
                                        class="form-control {{
                                            $errors->has('name_'.$category->id) 
                                            || Session::has('name_'.$category->id)
                                            ? 'is-invalid' : '' 
                                        }}">
                                    @if($errors->has('name_'.$category->id) || Session::has('name_'.$category->id))
                                        <div class="invalid-feedback">
                                            {{ 
                                                $errors->first('name_'.$category->id)
                                                ? $errors->first('name_'.$category->id)
                                                :Session::get('name_'.$category->id) 
                                            }}
                                        </div>
                                    @endif
                                </div>
                                <div class="actions">
                                    <button type="submit" class="btn btn-sm btn-success">Save</button>
                                    <button type="button" class="btn btn-sm btn-primary cancel-edit-category-btn">Cancel</button>
                                </div>
                            </div>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    @component('components.modal-delete', ['id' => 'deleteCategoryModal'])
        @slot('question')
            Are you sure you want to delete this category?
        @endslot
    @endcomponent
@endsection