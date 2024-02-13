@props(['order'])
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        p {
            margin-bottom: 20px;
        }

        a {
            color: #3498db;
            text-decoration: none;
        }

        a:hover {
            color: #2980b9;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
        }

        .highlight {
            background-color: #ffe600;
            padding: 5px;
            border-radius: 3px;
        }

        @media only screen and (max-width: 600px) {
            .container {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🎉 Order Confirmation</h1>
        <p>Dear {{$order->user->name}},</p>
        <p>Thank you for choosing us for your recent purchase. Your satisfaction is our priority, and we are thrilled to confirm your order.</p>
        <p><span class="highlight">Order Details:</span> Please see the attached file for a comprehensive breakdown of your order.</p>
        <p>If you have any questions, feel free to contact our support team at <a href="mailto:support@solarecom.com">support@solarecom.com</a>.</p>
        <p>We appreciate your business and look forward to serving you again.</p>
        <p>Best regards,<br> Solar Ecom Support Team</p>
    </div>
</body>
</html>
