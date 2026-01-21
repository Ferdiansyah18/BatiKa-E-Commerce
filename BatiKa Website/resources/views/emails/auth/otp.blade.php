<!DOCTYPE html>
<html>
<head>
    <title>Account Verification</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { 
            width: 100%; 
            max-width: 600px; 
            margin: 20px auto; 
            background: #ffffff; 
            border-radius: 8px; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.1); 
            overflow: hidden;
        }
        .header { 
            background-color: #3b82f6; 
            color: #ffffff; 
            padding: 20px; 
            text-align: center; 
        }
        .content { padding: 30px; text-align: center; }
        .otp-code { 
            font-size: 32px; 
            font-weight: bold; 
            letter-spacing: 5px; 
            color: #1e3a8a; 
            margin: 20px 0; 
            padding: 15px;
            background: #f0f9ff;
            border-radius: 8px;
            display: inline-block;
        }
        .footer { 
            background-color: #f8f9fa; 
            padding: 20px; 
            text-align: center; 
            font-size: 12px; 
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 style="margin:0;">Verification Code</h2>
        </div>
        <div class="content">
            <p>Hello,</p>
            <p>Thank you for registering with BatiKa! Please use the following code to verify your account.</p>
            
            <div class="otp-code">{{ $otp }}</div>

            <p>This code is valid for 10 minutes. <br>If you did not request this code, please ignore this email.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} BatiKa. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
