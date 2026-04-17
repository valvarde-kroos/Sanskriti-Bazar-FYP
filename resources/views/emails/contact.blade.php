<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Contact Form Message - Sanskriti Bazar</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .email-container {
            background: white;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #667eea;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #667eea;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            color: #666;
            margin: 5px 0 0 0;
        }
        .content {
            margin-bottom: 30px;
        }
        .field {
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
            border-left: 4px solid #667eea;
        }
        .field-label {
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
            display: block;
        }
        .field-value {
            color: #555;
            word-wrap: break-word;
        }
        .message-field {
            background: #fff;
            border: 1px solid #e2e8f0;
            padding: 20px;
            border-radius: 5px;
            margin-top: 10px;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            color: #666;
            font-size: 14px;
        }
        .timestamp {
            background: #e3f2fd;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 20px;
            color: #1976d2;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>🎵 Sanskriti Bazar</h1>
            <p>New Contact Form Message</p>
        </div>

        <div class="timestamp">
            📅 Received: {{ now()->format('F j, Y \a\t g:i A') }}
        </div>

        <div class="content">
            <div class="field">
                <span class="field-label">👤 Customer Name:</span>
                <span class="field-value">{{ $name }}</span>
            </div>

            <div class="field">
                <span class="field-label">📧 Email Address:</span>
                <span class="field-value">{{ $email }}</span>
            </div>

            @if($phone)
            <div class="field">
                <span class="field-label">📱 Phone Number:</span>
                <span class="field-value">{{ $phone }}</span>
            </div>
            @endif

            <div class="field">
                <span class="field-label">💬 Message:</span>
                <div class="message-field">
                    {{ $message }}
                </div>
            </div>
        </div>

        <div class="footer">
            <p><strong>Sanskriti Bazar</strong> - Traditional Musical Instruments of Nepal</p>
            <p>📍 Thamel, Kathmandu | 📞 +977 9816618275</p>
            <p style="font-size: 12px; color: #999; margin-top: 15px;">
                This email was automatically generated from your website contact form.
            </p>
        </div>
    </div>
</body>
</html>