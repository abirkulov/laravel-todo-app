@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="roles-container col-lg-6 offset-lg-3 col-md-6 offset-md-3 col-sm-8 offset-sm-2 px-0">
            <h3 class="mb-3">Updating a user role</h3>
            <div class="card mb-3">
                <div class="card-body">
                    <p class="h5">Update the user role for {{ $user->name }}</p>
                    <form method="post" action="{{ route('user.update.role', ['id' => $user->id]) }}" class="add-role">
                        @csrf
                        <div class="form-group mb-0 w-100 mb-3">
                            <label for="roles">Role:</label>
                            <select class="form-control {{ $errors->has('roles.0') ? 'is-invalid' : '' }}"
                                name="roles[]" id="roles" multiple data-placeholder="Choose some roles">
                                @foreach ($roles as $role)
                                    @if($role->id == old('roles.0') || $user->roles->contains($role->id))
                                        <option selected value="{{ $role->id }}">{{ $role->name }}</option>
                                    @else
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @if($errors->has('roles.0'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('roles.0') }}
                                </div>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-success">Save</button>
                        <a href="{{ route('user.store') }}" class="btn btn-primary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection