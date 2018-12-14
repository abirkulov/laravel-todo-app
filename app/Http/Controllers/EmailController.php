<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use App\Http\Requests\Email\SendMessageRequest;
use App\Models\User;

class EmailController extends Controller
{
    public function form()
    {
        return view('email-form');
    }

    public function send(SendMessageRequest $request)
    {
        $message = $request->message;
        $file = $request->file('img');

        Mail::to($request->email)->send(
            new SendEmail(
                'testapp@berkut.dev', 'Upload File', $message, $file
            )
        );

        setActionResponse('success', 'The Email has been successfully sent!');
        return redirect()->route('email.form');
    }
}
