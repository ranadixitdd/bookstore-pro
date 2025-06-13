<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password | Book Haven</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font + Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        /* ===============================
           ✨ NeonGlassPage RESET PASSWORD
        ================================ */
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

        .glass-box {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 40px 30px;
            box-shadow: 0 8px 32px 0 rgba(0, 255, 255, 0.25);
            backdrop-filter: blur(14px);
            -webkit-backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            width: 380px;
            color: #e0f7fa;
            text-align: center;
            position: relative;
        }

        .glass-box::before {
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

        h2 {
            font-size: 24px;
            color: #00ffe7;
            margin-bottom: 20px;
        }

        label {
            text-align: left;
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
            color: #b2ebf2;
        }

        input {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: none;
            background: rgba(255, 255, 255, 0.08);
            color: #00fff2;
            font-size: 14px;
            box-shadow: inset 0 0 10px rgba(0, 255, 255, 0.2);
        }

        .error-message {
            color: #ff6b6b;
            font-size: 13px;
            text-align: left;
            margin-bottom: 10px;
        }

        button {
            background: linear-gradient(135deg, #00ffe7, #00b0ff);
            color: #000;
            font-weight: bold;
            padding: 12px;
            border-radius: 8px;
            border: none;
            font-size: 15px;
            cursor: pointer;
            width: 100%;
            box-shadow: 0 0 20px rgba(0, 255, 255, 0.3);
            transition: 0.3s;
        }

        button:hover {
            transform: scale(1.04);
            box-shadow: 0 0 25px rgba(0, 255, 255, 0.5);
        }
    </style>
</head>
<body>
    <div class="glass-box">
        <h2>Reset Password</h2>
        <form action="<?php echo e(route('password.update')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="token" value="<?php echo e($token); ?>">

            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>" required>
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error-message"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            <label for="password">New Password</label>
            <input type="password" name="password" id="password" required>
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="error-message"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>

            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>
<?php /**PATH C:\Users\Rana Dixit\BookStore\BookStore\resources\views/auth/reset-password.blade.php ENDPATH**/ ?>