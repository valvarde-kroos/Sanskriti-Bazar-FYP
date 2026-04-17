<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Your Password - Sanskriti Bazar</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .email-header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
        }
        .email-header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 16px;
        }
        .email-body {
            padding: 40px 30px;
        }
        .email-body h2 {
            color: #2d3748;
            font-size: 24px;
            margin-bottom: 20px;
        }
        .email-body p {
            color: #4a5568;
            font-size: 16px;
            margin-bottom: 20px;
        }
        .reset-button {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 16px;
            margin: 20px 0;
            transition: all 0.3s ease;
        }
        .reset-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }
        .security-info {
            background: #f7fafc;
            border-left: 4px solid #667eea;
            padding: 20px;
            margin: 30px 0;
            border-radius: 0 8px 8px 0;
        }
        .security-info h3 {
            color: #2d3748;
            margin: 0 0 10px 0;
            font-size: 18px;
        }
        .security-info p {
            margin: 0;
            font-size: 14px;
            color: #718096;
        }
        .email-footer {
            background: #f8f9fa;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
        .email-footer p {
            margin: 0;
            color: #718096;
            font-size: 14px;
        }
        .link-text {
            word-break: break-all;
            background: #f7fafc;
            padding: 10px;
            border-radius: 4px;
            font-family: monospace;
            font-size: 14px;
            color: #4a5568;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>🎵 Sanskriti Bazar</h1>
            <p>Traditional Musical Instruments Marketplace</p>
        </div>
        
        <div class="email-body">
            <h2>Reset Your Password</h2>
            
            <p>Hello {{ $user->name }},</p>
            
            <p>We received a request to reset your password for your Sanskriti Bazar account. If you made this request, click the button below to reset your password:</p>
            
            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $resetUrl }}" class="reset-button">Reset My Password</a>
            </div>
            
            <p>If the button doesn't work, you can copy and paste this link into your browser:</p>
            <div class="link-text">{{ $resetUrl }}</div>
            
            <div class="security-info">
                <h3>🔒 Security Information</h3>
                <p><strong>This link will expire in 24 hours</strong> for your security.</p>
                <p>If you didn't request a password reset, please ignore this email. Your password will remain unchanged.</p>
                <p>For security reasons, never share this link with anyone.</p>
            </div>
            
            <p>If you have any questions or need help, please contact our support team.</p>
            
            <p>Best regards,<br>
            <strong>The Sanskriti Bazar Team</strong></p>
        </div>
        
        <div class="email-footer">
            <p>&copy; {{ date('Y') }} Sanskriti Bazar. All rights reserved.</p>
            <p>Traditional Musical Instruments Marketplace</p>
        </div>
    </div>
</body>
</html>