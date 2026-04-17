<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Thank You for Contacting Sanskriti Bazar</title>
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
        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }
        .message-box {
            background: #f0f8ff;
            border: 1px solid #667eea;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .info-box {
            background: #f8f9fa;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
            border-left: 4px solid #28a745;
        }
        .contact-info {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 5px;
            padding: 15px;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            color: #666;
            font-size: 14px;
        }
        .social-links {
            text-align: center;
            margin: 20px 0;
        }
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #667eea;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>🎵 Sanskriti Bazar</h1>
            <p>Traditional Musical Instruments of Nepal</p>
        </div>

        <div class="content">
            <div class="greeting">
                Hello {{ $name }},
            </div>

            <div class="message-box">
                <p><strong>Thank you for contacting us!</strong></p>
                <p>We have received your message and truly appreciate you reaching out to Sanskriti Bazar. Our team will review your inquiry and get back to you within <strong>24 hours</strong>.</p>
            </div>

            <div class="info-box">
                <p><strong>📝 Your Message Summary:</strong></p>
                <p><strong>Name:</strong> {{ $name }}</p>
                <p><strong>Email:</strong> {{ $email }}</p>
                @if($phone)
                <p><strong>Phone:</strong> {{ $phone }}</p>
                @endif
                <p><strong>Submitted:</strong> {{ now()->format('F j, Y \a\t g:i A') }}</p>
            </div>

            <div class="contact-info">
                <p><strong>📞 Need Immediate Assistance?</strong></p>
                <p>Phone/WhatsApp: <strong>+977 9816618275</strong></p>
                <p>Email: <strong>grgprabesh888@gmail.com</strong></p>
                <p>Location: <strong>Thamel, Kathmandu</strong></p>
                <p><strong>Business Hours:</strong> Sunday - Friday, 10:00 AM - 6:00 PM</p>
            </div>

            <p>In the meantime, feel free to browse our collection of authentic Nepali musical instruments on our website. Each instrument tells a story of our rich cultural heritage.</p>

            <div class="social-links">
                <p><strong>Follow us:</strong></p>
                <a href="#">📘 Facebook</a> | <a href="#">📸 Instagram</a>
            </div>
        </div>

        <div class="footer">
            <p><strong>Sanskriti Bazar</strong></p>
            <p>Preserving Nepal's Musical Heritage Through Traditional Instruments</p>
            <p style="font-size: 12px; color: #999; margin-top: 15px;">
                This is an automated confirmation email. Please do not reply to this email.
            </p>
        </div>
    </div>
</body>
</html>