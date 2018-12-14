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
        <div class="mail-container col-6 offset-sm-3">
            <h3 class="mb-3">Sending an Email</h3>
            <form method="post" action="{{ route('email.send') }}" class="send-email" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="title">To whom:</label>
                    <input type="text" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" 
                        id="title" name="email" aria-describedby="titleHelp" placeholder="Enter an email"
                        value="{{ old('email') }}">
                    @if($errors->has('email'))
                        <div class="invalid-feedback">
                            {{ $errors->first('email') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="text">Message:</label>
                    <textarea class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}" 
                        id="text" name="message" rows="10">{{ old('message') }}</textarea>
                    @if($errors->has('message'))
                        <div class="invalid-feedback">
                            {{ $errors->first('message') }}
                        </div>
                    @endif
                </div>
                <div class="form-group">
                    <label>Image:</label><br>
                    <input type="file" id="img" name="img" class="{{ $errors->has('img') ? 'invalid-file' : '' }}">
                    @if($errors->has('img'))
                        <div class="invalid-feedback">
                            {{ $errors->first('img') }}
                        </div>
                    @endif
                </div>
                @csrf
                <button type="submit" class="btn btn-primary">Send</button>
            </form>
        </div>
    </div>
@endsection