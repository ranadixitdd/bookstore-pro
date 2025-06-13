<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | Book Haven</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap');

        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 40px 30px;
            box-shadow: 0 8px 32px 0 rgba(0, 255, 255, 0.25);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            width: 360px;
            color: #e0f7fa;
            text-align: center;
            position: relative;
        }

        .glass-card::before {
            content: '';
            position: absolute;
            top: -50px;
            left: -50px;
            width: 120px;
            height: 120px;
            background: #00ffe7;
            filter: blur(80px);
            z-index: -1;
        }

        h3 {
            font-size: 26px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #00ffe7;
        }

        p {
            font-size: 14px;
            color: #b2ebf2;
            margin-bottom: 15px;
        }

        input[type="email"] {
            width: 100%;
            padding: 12px 14px;
            margin-bottom: 10px;
            border-radius: 8px;
            border: none;
            outline: none;
            font-size: 14px;
            background: rgba(255, 255, 255, 0.08);
            color: #00fff2;
            box-shadow: inset 0 0 10px rgba(0, 255, 255, 0.2);
        }

        .error-message {
            background: rgba(255, 0, 0, 0.1);
            color: #ff6b6b;
            font-size: 13px;
            padding: 8px;
            border-radius: 5px;
            margin-bottom: 10px;
            text-align: left;
        }

        .hint-message {
            background: rgba(0, 255, 150, 0.1);
            color: #00ff95;
            padding: 10px;
            border-left: 4px solid #00ff95;
            border-radius: 6px;
            font-size: 13px;
            margin-bottom: 15px;
            text-align: left;
        }

        .box-btn {
            background: linear-gradient(135deg, #00ffe7, #00b0ff);
            color: #000;
            font-weight: bold;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
            transition: 0.3s;
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.3);
        }

        .box-btn:hover {
            transform: scale(1.04);
            box-shadow: 0 0 25px rgba(0, 255, 255, 0.5);
        }

        .message {
            background: rgba(0, 255, 150, 0.1);
            color: #00ff95;
            padding: 12px;
            border-left: 4px solid #00ff95;
            border-radius: 6px;
            font-size: 14px;
            margin-bottom: 20px;
            text-align: left;
        }

        a {
            color: #00ffe7;
            text-decoration: none;
            display: inline-block;
            margin-top: 15px;
            font-size: 14px;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="glass-card">

        <!-- ✅ If reset sent -->
        @if(session('status'))
            <div class="message">
                <i class="fas fa-check-circle"></i> {{ session('status') }}
            </div>
        @endif

        @if(session('reset_link'))
            <div class="message" style="background: #222; color: #00e7ff;">
                🔗 <strong>Reset Link:</strong><br>
                <a href="{{ session('reset_link') }}" style="color: #00ffe7; word-break: break-all;">
                    {{ session('reset_link') }}
                </a>
            </div>
        @endif

        <!-- 💡 Always show helpful hint -->
        <div class="hint-message">
            <i class="fas fa-info-circle"></i> Enter your registered email and click “Send Reset Link.” A secure link will be sent to your email.
        </div>

        <h3>Forgot Password?</h3>
        <p>We’ll help you reset it.</p>

        <!-- 🔹 FORM -->
        <form action="{{ route('password.email') }}" method="POST">
            @csrf

            <!-- 📧 Email -->
            <input type="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" required>

            <!-- ❌ Error -->
            @error('email')
                <div class="error-message"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
            @enderror

            <!-- 🎯 Button -->
            <button type="submit" class="box-btn">Send Reset Link</button>
        </form>

        <a href="{{ route('login') }}"><i class="fas fa-arrow-left"></i> Back to Login</a>
    </div>

</body>
</html>
