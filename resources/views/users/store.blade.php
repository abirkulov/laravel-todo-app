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
        <div class="users-container px-0">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="align-middle" scope="col">#</th>
                        <th class="align-middle" scope="col">Name</th>
                        <th class="align-middle" scope="col">Email</th>
                        <th class="align-middle" scope="col">Roles</th>
                        <th class="align-middle" scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $key => $user)
                        <tr>
                            <th class="align-middle" scope="row">{{ $key + 1 }}</th>
                            <td class="align-middle">{{ $user->name }}</td>
                            <td class="align-middle">{{ $user->email }}</td>
                            @if($user->roles->isNotEmpty())
                                <td class="align-middle">
                                    @foreach ($user->roles as $role)
                                        <span class="d-block">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                            @else
                                <td class="align-middle">No roles are given</td>
                            @endif
                            <td class="align-middle">
                                <a href="{{ route('users.edit.role', ['id' => $user->id]) }}" class="btn btn-sm btn-primary">Edit</a>
                                <a href="javascript:void(0)" class="btn btn-sm btn-danger delete-user-btn" 
                                    data-id="{{ $user->id }}" data-toggle="modal" data-target="#deleteUserModal">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @component('components.modal-delete', ['id' => 'deleteUserModal'])
        @slot('question')
            Are you sure you want to delete this user?
        @endslot
    @endcomponent
@endsection