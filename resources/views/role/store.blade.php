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
        <div class="roles-container">
            <div class="role-title-block mb-3 d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Roles Store</h3>
                <div class="add-post">
                    <a href="{{ route('role.create') }}" class="btn btn-primary">Create a role</a>
                </div>
            </div>
            <ul class="list-group">
                @foreach ($roles as $role)
                    <li class="list-group-item">
                        <div class="role-display {{ $errors->has('name') || Session::has('name') ? 'd-none' : 'd-block' }}">
                            <div class="flex-container d-flex justify-content-between align-items-center">
                                <p class="role-name h5 mb-0">{{ $role->name }}</p>
                                <div class="actions">
                                    <a href="{{ route('role.edit', ['id' => $role->id]) }}" class="btn btn-sm btn-primary edit-role-btn">Edit</a>
                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger mr-auto delete-role-btn" data-toggle="modal"
                                        data-target="#deleteRoleModal" data-id="{{ $role->id }}">Delete</a>
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>

    @component('components.modal-delete', ['id' => 'deleteRoleModal'])
        @slot('question')
            Are you sure you want to delete this role?
        @endslot
    @endcomponent
@endsection