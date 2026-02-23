<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #e1e1e1;
            border-radius: 10px;
        }

        .header {
            background: linear-gradient(90deg, #00F5FF, #7A00FF);
            padding: 30px;
            border-radius: 10px 10px 0 0;
            color: white;
            text-align: center;
        }

        .content {
            padding: 30px;
            background: white;
            border-radius: 0 0 10px 10px;
            border: 1px solid #eee;
            border-top: none;
        }

        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 20px;
        }

        .button {
            display: inline-block;
            padding: 12px 24px;
            background: #00F5FF;
            color: #000;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Thank You, {{ $contact->name }}!</h1>
        </div>
        <div class="content">
            <p>Hi {{ $contact->name }},</p>
            <p>Thank you for reaching out! I've received your message regarding
                "<strong>{{ $contact->subject }}</strong>".</p>
            <p>I value your interest and will get back to you as soon as possible. In the meantime, feel free to check
                out my latest projects on my portfolio.</p>

            <center>
                <a href="{{ config('app.url') }}" class="button">Visit Portfolio</a>
            </center>

            <p style="margin-top: 30px;">Best regards,<br><strong>Awais Ahmad</strong></p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Awais Ahmad Portfolio
        </div>
    </div>
</body>

</html>