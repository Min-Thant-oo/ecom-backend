<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            color: #333;
            background-color: #f4f4f4;
        }

        .container {
            word-wrap: break-word;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            
        }
      .button-center {
        text-align: center;
        padding-top: 5px;
        padding-bottom: 5px;
      }

        h2 {
            color: #E77600;
        }

        p {
            color: #666;
            line-height: 1.5;
        }

        a {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3182CE;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #2c6aa0;
        }
      
      .link {
            display: inline;
            padding: 0 0 0 0;
            background-color: inherit;
            text-decoration: underline;
            border-radius:0%;
            transition: none;
            color: #0000EE;
        }

        .link {
            background-color: inherit;
        }
    </style>
</head>
<body>

    <div class="container">

        <h2 style="text-align: center">Forgot Password?</h2>

        <p>Hello {{ $user->name }},</p>

        <p>We received a request to reset your password. If you did not make this request, you can ignore this email.</p>

        <p>To reset your password, click on the following button:</p>

        <div class="button-center">
            <a href="{{"http://localhost:3000/{$user->remember_token}/{$user->email}/resetpassword"}}" style="text-decoration: none;">Reset Password</a>
        </div>

        <p>If you're having trouble clicking the "Reset Password" button, copy and paste the following URL into your web browser:</p>

        {{-- <p>{{ url('/reset', $user->remember_token) }}</p> --}}
        <p><a href="{{"http://localhost:3000/{$user->remember_token}/{$user->email}/resetpassword" }}" class="link">{{"http://localhost:3000/{$user->remember_token}/{$user->email}/resetpassword" }}</a></p>


        <p>This link will expire in {{ config('auth.passwords.users.expire') }} minutes.</p>

        <p>If you did not request a password reset, no further action is required.</p>
        <p>If you have any questions, feel free to contact our support team at <a class="link"  href="mailto:support@solarecom.com">support@solarecom.com</a>.</p>

        <p>Best regards,<br>Solar Ecom Support Team</p>
    </div>

</body>
</html>
