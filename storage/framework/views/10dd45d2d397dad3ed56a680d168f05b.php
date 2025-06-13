<?php $__env->startSection('title', 'Edit Product'); ?>

<?php $__env->startSection('content'); ?>
<!-- Particle Background -->
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

<!-- Edit Product Form -->
<div class="container">
    <h2>Edit Product</h2>

    <form action="<?php echo e(route('admin.products.update', $product->id)); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <label>Product Name:</label>
        <input type="text" name="name" value="<?php echo e($product->name); ?>" required>

        <label>Description:</label>
        <textarea name="description" required><?php echo e($product->description); ?></textarea>

        <label for="title">Title:</label>
        <input type="text" id="title" name="title" required>

        <label for="author">Author:</label>
        <input type="text" name="author" id="author" value="<?php echo e(old('author', $product->author ?? '')); ?>" required>

        <label>Price:</label>
        <input type="number" name="price" step="0.01" value="<?php echo e($product->price); ?>" required>

        <label>Stock:</label>
        <input type="number" name="stock" value="<?php echo e($product->stock); ?>" required>

        <label>Current Image:</label><br>
        <div class="image-preview">
            <img src="<?php echo e(asset('images/' . $product->image)); ?>">
        </div>

        <label>Change Image:</label>
        <input type="file" name="image">

        <label for="category">Select Category:</label>
        <select name="category_id" id="category" required>
            <option value="">-- Select Category --</option>
            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($category->id); ?>" <?php echo e($product->category_id == $category->id ? 'selected' : ''); ?>>
                <?php echo e($category->name); ?>

            </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <button type="submit" class="btn">Update Product</button>
    </form>
</div>

<!-- Particle JS -->
<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>
<script>
    particlesJS.load('particles-js', 'particles.json', function () {
        console.log('particles.js config loaded');
    });
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rana Dixit\BookStore\BookStore\resources\views/admin/products/edit.blade.php ENDPATH**/ ?>