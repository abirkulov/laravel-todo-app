@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="roles-container col-lg-6 offset-lg-3 col-md-6 offset-md-3 col-sm-8 offset-sm-2 px-0">
            <h3 class="mb-3">Creating a role</h3>
            <div class="card mb-3">
                <div class="card-body">
                    <form method="post" action="{{ route('roles.update', ['id' => $role->id]) }}" class="add-role">
                        @csrf
                        <div class="form-group">
                            <label for="role">Role name:</label>
                            <input id="name" name="name" value="{{ old('name') ?? $role->name }}" placeholder="Enter a role name" 
                                class="form-control {{ 
                                    $errors->has('name') || Session::has('name') ? 'is-invalid' : '' 
                                }}">
                            @if($errors->has('name') || Session::has('name'))
                                <div class="invalid-feedback">
                                    {{ Session::get('name') ?? $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group mb-3 w-100">
                            <label for="permissions">Permissions:</label>
                            <select class="form-control {{ $errors->has('permissions.0') ? 'is-invalid' : '' }}" 
                                name="permissions[]" id="permissions" multiple data-placeholder="Choose some permissions">
                                @foreach ($permissions as $permission)
                                    @if($permission->id == old('permissions.0') || $role->permissions->contains($permission->id))
                                        <option selected value="{{ $permission->id }}">{{ $permission->name }}</option>
                                    @else
                                        <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if($errors->has('permissions.0'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('permissions.0') }}
                                </div>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-success">Save</button>
                        <a href="{{ route('roles.store') }}" class="btn btn-primary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection