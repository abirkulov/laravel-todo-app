<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sending Email</title>
</head>
<body>
    <div class="mail-content">
        <h4>Hello, World!</h4>
        <div class="text-message">
            <p>From: {{ $emailFrom }}</p>
            <p>{{ $text }}</p>
            <img src="{{ $message->embed($file->getRealPath()) }}">
        </div>
    </div>
</body>
</html>