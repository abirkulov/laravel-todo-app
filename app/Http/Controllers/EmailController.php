<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;
use App\Http\Requests\Email\SendMessageRequest;
use App\Models\User;
use App\Jobs\ProcessMailSending;

class EmailController extends Controller
{
    public function __construct()
    {
        view()->share('page', 'email');    
    }
    
    public function form()
    {
        return view('email-form');
    }

    public function send(SendMessageRequest $request)
    {
        $to = $request->email;
        $message = $request->message;
        $file = $request->file('img');
        $rawData = base64_encode(
            file_get_contents($file->getRealPath())
        );

        $mailData = [
            'to' => $to,
            'from' => 'testapp@berkut.dev',
            'subject' => 'Upload File', 
            'message' => $message,
            'fileName' => $file->getClientOriginalName(),
            'attachment' => $rawData
        ];

        ProcessMailSending::dispatch($mailData)
            ->delay(now()->addSeconds(5));

        setActionResponse('success', 'The Email has been successfully sent!');
        return redirect()->route('email.form');
    }
}
