<!DOCTYPE html>
<html>
<head>
    <title>Contact Form Submission</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .content {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            border: 1px solid #e9ecef;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>New Contact Form Submission</h2>
    </div>
    
    <div class="content">
        <p><strong>From:</strong> {{ $name }} ({{ $email }})</p>
        <p><strong>Subject:</strong> {{ $subject }}</p>
        
        <h3>Message:</h3>
        <p>{!! nl2br(e($message)) !!}</p>
    </div>
    
    <div class="footer">
        <p>This email was sent from the contact form on the DIU ACM website.</p>
    </div>
</body>
</html> 