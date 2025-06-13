<?php $__env->startSection('content'); ?>

<!-- Particles Background -->
<div id="particles-js"></div>

<!-- Neon Glassmorphism CSS -->
<style>
    body {
        margin: 0;
        padding: 0;
        background: linear-gradient(to right, #0f0c29, #302b63, #24243e);
        font-family: 'Inter', sans-serif;
        color: #fff;
        overflow-x: hidden;
    }

    #particles-js {
        position: fixed;
        width: 100%;
        height: 100%;
        z-index: -1;
    }

    .container {
        max-width: 650px;
        margin: 50px auto;
        background: rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(15px);
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        padding: 30px;
        box-shadow: 0 0 30px rgba(0, 247, 255, 0.2);
    }

    h2 {
        text-align: center;
        color: #00f7ff;
        margin-bottom: 30px;
    }

    label {
        font-weight: 600;
        margin-top: 15px;
        display: block;
    }

    input, textarea, select {
        width: 100%;
        padding: 10px 14px;
        margin-top: 5px;
        background: rgba(0, 0, 0, 0.3);
        color: #fff;
        border: 1px solid #00f7ff;
        border-radius: 8px;
        outline: none;
        transition: 0.3s ease-in-out;
    }

    input:focus, textarea:focus, select:focus {
        border-color: #0ff;
        box-shadow: 0 0 10px #00f7ff;
    }

    .image-preview img {
        border-radius: 8px;
        border: 2px solid #00f7ff;
        width: 100px;
        height: auto;
        margin-top: 10px;
    }

    .btn {
        margin-top: 25px;
        padding: 12px;
        background: #00f7ff;
        color: #000;
        border: none;
        border-radius: 10px;
        font-weight: bold;
        transition: 0.3s;
        box-shadow: 0 0 15px #00f7ff;
    }

    .btn:hover {
        background: #0ff;
        box-shadow: 0 0 25px #00f7ff, 0 0 35px #00f7ff;
        transform: scale(1.03);
    }
</style>

<div class="container">
    <h2>Add New Product</h2>

    <!-- Success Message -->
    <?php if(session('success')): ?>
        <div style="color: green; margin-bottom: 15px;">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <!-- Validation Errors -->
    <?php if($errors->any()): ?>
        <div style="color: red; margin-bottom: 15px;">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('admin.products.store')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>

        <label for="name">Product Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>

        <div class="form-group">
            <label for="author">Author</label>
            <input type="text" name="author" id="author" class="form-control" value="<?php echo e(old('author')); ?>" required>
        </div>

        <label for="description">Description:</label>
        <textarea id="description" name="description" rows="3" required></textarea>

        <label for="price">Price (₹):</label>
        <input type="number" id="price" name="price" step="0.01" required>

        <label for="stock">Stock:</label>
        <input type="number" id="stock" name="stock" required>

        <label for="image">Product Image:</label>
        <input type="file" id="image" name="image" accept="image/*">

        <label for="category">Select Category:</label>
        <select name="category_id" id="category" required>
            <option value="">-- Select Category --</option>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <button type="submit" class="btn">Add Product</button>
    </form>
</div>

<!-- particles.js CDN + Config Loader -->
<script src="https://cdn.jsdelivr.net/npm/particles.js"></script>
<script>
    particlesJS.load('particles-js', '<?php echo e(asset('particles.json')); ?>', function () {
        console.log('particles.js loaded – background running.');
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rana Dixit\BookStore\BookStore\resources\views/admin/products/add.blade.php ENDPATH**/ ?>