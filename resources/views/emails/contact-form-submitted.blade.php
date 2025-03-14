<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Contact Form Message</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-radius: 0 0 5px 5px;
            font-size: 14px;
            color: #777;
        }
        h1 {
            color: #333;
        }
        .message-details {
            margin-bottom: 20px;
        }
        .message-details strong {
            width: 100px;
            display: inline-block;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>New Contact Form Message</h1>
    </div>
    <div class="content">
        <p>You have received a new message from the contact form on your website.</p>

        <div class="message-details">
            <p><strong>Name:</strong> {{ $contactMessage->name }}</p>
            <p><strong>Email:</strong> {{ $contactMessage->email }}</p>
            <p><strong>Date:</strong> {{ $contactMessage->created_at->format('F j, Y, g:i a') }}</p>
        </div>

        <h3>Message:</h3>
        <p>{{ $contactMessage->message }}</p>
    </div>
    <div class="footer">
        <p>This is an automated email from your Data Bank website.</p>
    </div>
</div>
</body>
</html>
