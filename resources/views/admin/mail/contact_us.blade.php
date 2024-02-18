{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <p>hi, {{$contactus->name}}</p>
    <p>{{$contactus->email}}</p>
    <p>{{$contactus->subject}}</p>
    <p>{{$contactus->message}}</p>
</body>
</html> --}}




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact Us Email</title>
</head>
<body style="font-family: Arial, sans-serif;">

    <div style="max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f9f9f9; border-radius: 5px;">

        <h2 style="margin-top: 0;">New Contact Us Form Submission</h2>

        <p style="margin-bottom: 15px;">Dear Admin,</p>

        <p>You have received a new message from a visitor via the Contact Us form. Here are the details:</p>

        <ul style="list-style-type: none; padding: 0;">
            <li><strong>Name:</strong> {{ $contactus->name }}</li>
            <li><strong>Email:</strong> <a href="mailto:{{$contactus->email}}">{{ $contactus->email }}</a></li>
            <li><strong>Subject:</strong> {{ $contactus->subject }}</li>
        </ul>

        <p style="margin-top: 15px;"><strong>Message:</strong></p>
        <p>{{ $contactus->message }}</p>

        <p style="margin-top: 20px;">Please take appropriate action and respond to the inquiry promptly.</p>

        <p style="margin-top: 20px;">Thank you,</p>
        <p>Solar Ecom</p>

    </div>

</body>
</html>
