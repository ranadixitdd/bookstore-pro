<?php $__env->startSection('content'); ?>
<style>
    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        /* background: linear-gradient(135deg, #0f2027, #203a43, #2c5364); */
        
        background-attachment: fixed;
        overflow-x: hidden;
    }

    .neon-glass-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 80vh;
        padding: 40px 20px;
    }

    .glass-container {
        background: rgba(255, 255, 255, 0.07);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-radius: 20px;
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        padding: 40px 30px;
        width: 100%;
        max-width: 500px;
        text-align: center;
        box-shadow: 0 0 30px rgba(0, 255, 200, 0.2), 0 0 60px rgba(0, 255, 255, 0.1);
        animation: fadeInUp 1s ease;
    }

    .glass-container h2 {
        color: #00ffcc;
        font-size: 28px;
        margin-bottom: 15px;
        text-shadow: 0 0 8px #00ffe7, 0 0 16px #00ffe7;
    }

    .glass-container p {
        color: #f0f0f0;
        font-size: 16px;
        margin-bottom: 30px;
    }

    .neon-button {
        background: transparent;
        border: 2px solid #00d9ff;
        color: #00d9ff;
        padding: 12px 25px;
        border-radius: 30px;
        font-weight: bold;
        text-decoration: none;
        font-size: 16px;
        transition: all 0.3s ease;
        box-shadow: 0 0 10px #00d9ff, 0 0 20px #00d9ff inset;
    }

    .neon-button:hover {
        background: #00d9ff;
        color: #000;
        box-shadow: 0 0 15px #00f7ff, 0 0 30px #00f7ff;
        transform: scale(1.05);
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="neon-glass-wrapper">
    <div class="glass-container">
        <h2>🎉 Order Placed Successfully! 🎉</h2>
        <p>Thank you for your purchase. Your order is being processed.</p>
        <a href="<?php echo e(route('books.index')); ?>" class="neon-button">📚 Browse More Books</a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rana Dixit\BookStore\BookStore\resources\views/checkout/confirmation.blade.php ENDPATH**/ ?>