<?php $__env->startSection('content'); ?>

<div class="profile-container">
    <h2>📝 Edit Profile</h2>

    <!-- ✅ SUCCESS MESSAGE -->
    <?php if(session('success')): ?>
        <p class="success-message"><?php echo e(session('success')); ?></p>
    <?php endif; ?>

    <!-- 📝 PROFILE EDIT FORM -->
    <form action="<?php echo e(route('profile.update')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <!-- 📌 PROFILE IMAGE SECTION -->
        <div class="profile-image-container">
            <img id="preview" src="<?php echo e(asset(auth()->user()->profile_image ?? 'images/images.png')); ?>" alt="Profile Image" class="profile-img">
            <label for="profile_image" class="custom-file-upload">Change Profile Picture</label>
            <input type="file" id="profile_image" name="profile_image" accept="image/*" onchange="previewImage(event)">
        </div>
        <?php $__errorArgs = ['profile_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <!-- 📌 INPUT FIELDS -->
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo e(auth()->user()->name); ?>" required>
        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo e(auth()->user()->email); ?>" required>
        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone" value="<?php echo e(auth()->user()->phone); ?>">
        <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <label for="address">Address:</label>
        <input type="text" id="address" name="address" value="<?php echo e(auth()->user()->address); ?>">
        <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <!-- OPTIONAL BIO FIELD -->
        

        <!-- 🔐 PASSWORD UPDATE -->
        <label for="old_password">Old Password:</label>
        <input type="password" id="old_password" name="old_password" placeholder="Enter old password" required>
        <?php $__errorArgs = ['old_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <label for="password">New Password (optional):</label>
        <input type="password" id="password" name="password" placeholder="Enter new password">
        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <label for="password_confirmation">Confirm New Password:</label>
        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password">
        <?php $__errorArgs = ['password_confirmation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <!-- 📌 SUBMIT BUTTON -->
        <button type="submit" class="btn-update">Update Profile</button>
    </form>
</div>
<style>
    body {
        font-family: 'Inter', sans-serif;
        /* background: linear-gradient(135deg, #0f0c29, #302b63, #24243e); */
        background: url('<?php echo e(asset("images/op.jpg")); ?>') no-repeat center center fixed;
        background-size: cover;
        margin: 0;
        padding: 0;
        color: #fff; /* Ensures text is visible */
    }

    .profile-container {
        max-width: 720px;
        margin: 60px auto;
        padding: 35px;
        border-radius: 20px;
        backdrop-filter: blur(15px);
        background: rgba(255, 255, 255, 0.05);
        box-shadow: 0 8px 32px rgba(0, 247, 255, 0.3);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: #fff;
    }

    /* Headings */
    h2 {
        font-size: 2rem;
        text-align: center;
        margin-bottom: 25px;
        color: #00f7ff;
        text-shadow: 0 0 5px #00f7ff;
    }

    /* Profile image */
    .profile-img {
        width: 140px;
        height: 140px;
        border-radius: 50%;
        border: 4px solid #00f7ff;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .profile-img:hover {
        transform: scale(1.05);
    }

    .custom-file-upload {
        display: inline-block;
        background: #00f7ff;
        color: #000;
        font-weight: 600;
        padding: 10px 18px;
        margin-top: 12px;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s;
    }
    .custom-file-upload:hover {
        background: #0ff;
        box-shadow: 0 0 10px #00f7ff;
    }
    input[type="file"] {
        display: none;
    }

    /* Inputs */
    label {
        font-weight: bold;
        margin-top: 15px;
        display: block;
        color: #fff;
    }
    input, textarea {
        width: 100%;
        padding: 12px;
        margin: 6px 0 16px;
        background: rgba(255, 255, 255, 0.07);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        color: #fff;
        font-size: 1rem;
    }
    input:focus, textarea:focus {
        outline: none;
        box-shadow: 0 0 5px #00f7ff;
        border-color: #00f7ff;
        background: rgba(255, 255, 255, 0.1);
    }

    /* Error + Success messages */
    .error {
        color: #ff4d4d;
        font-size: 0.9rem;
    }
    .success-message {
        color: #00ff88;
        text-align: center;
        font-weight: 600;
        margin-bottom: 20px;
    }

    /* Button */
    .btn-update {
        width: 100%;
        padding: 14px;
        font-size: 1rem;
        font-weight: 600;
        border: none;
        border-radius: 10px;
        background: #00f7ff;
        color: #000;
        cursor: pointer;
        transition: background 0.3s, box-shadow 0.3s;
    }
    .btn-update:hover {
        background: #0ff;
        box-shadow: 0 0 15px #00f7ff;
    }

    /* Responsive */
    @media (max-width: 500px) {
        .profile-container {
            padding: 25px;
            margin: 20px;
        }

        .btn-update {
            font-size: 0.95rem;
            padding: 12px;
        }

        .profile-img {
            width: 120px;
            height: 120px;
        }
    }
    </style>


<script>
// Live preview of profile image upload
function previewImage(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rana Dixit\BookStore\BookStore\resources\views/user/edit.blade.php ENDPATH**/ ?>