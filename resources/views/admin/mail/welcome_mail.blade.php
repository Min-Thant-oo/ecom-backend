<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Solar Ecom</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            color: #333;
        }

        h1 {
            color: #E77600;
        }

        p {
            color: #666;
            line-height: 1.5;
        }

        a {
            color: #3182CE;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div>

        <h1>Welcome to Solar Ecom!</h1>

        <p>Dear {{ $formData['name'] }},</p>

        <p>Thank you for joining Solar Ecom. We're thrilled to have you on board!</p>

        <p>If you have any questions, feel free to contact our support team at <a href="mailto:support@solarecom.com">support@solarecom.com</a>.</p>

        <p>Best regards,<br>Solar Ecom Team</p>

    </div>
</body>
</html>
