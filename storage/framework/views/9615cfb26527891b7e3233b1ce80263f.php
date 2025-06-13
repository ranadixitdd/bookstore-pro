<?php $__env->startSection('title', 'My Wishlist'); ?>

<?php $__env->startSection('content'); ?>
<div class="container neon-glass-page">
    <h2 class="mb-4 text-center">📌 My Wishlist (<?php echo e($wishlistCount); ?>)</h2>

    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <?php if($wishlists->isEmpty()): ?>
        <p class="text-center">Your wishlist is empty.</p>
    <?php else: ?>
        <div class="wishlist-container">
            <?php $__currentLoopData = $wishlists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wishlist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($wishlist->book): ?>
                <div class="wishlist-card">
                    <?php if($wishlist->book->image && file_exists(public_path('images/' . $wishlist->book->image))): ?>
                        <img src="<?php echo e(asset('images/' . $wishlist->book->image)); ?>"
                             alt="<?php echo e($wishlist->book->title); ?>"
                             class="wishlist-img">
                    <?php endif; ?>

                    <div class="wishlist-info">
                        <h3 class="book-title"><?php echo e($wishlist->book->title); ?></h3>
                        <p class="book-price">💰 $<?php echo e(number_format($wishlist->book->price, 2)); ?></p>
                        <p class="wishlist-rating">⭐ <?php echo e(number_format($wishlist->book->average_rating, 1)); ?> / 5</p>
                        <p class="wishlist-date">🗓 Added on <?php echo e($wishlist->created_at->format('F j, Y')); ?></p>
                    </div>

                    <i class="fa-heart wishlist-icon <?php echo e(isset($wishlist->book) ? 'fas' : 'far'); ?>"
                       data-book-id="<?php echo e($wishlist->book->id); ?>"></i>

                    <div class="wishlist-actions">
                        <form action="<?php echo e(route('cart.add', ['id' => $wishlist->book->id])); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="move-to-cart">🛒 Move to Cart</button>
                        </form>
                    </div>

                    <a href="<?php echo e(route('products.details', ['id' => $wishlist->book->id])); ?>"
                       class="btn btn-primary">📖 View Details</a>
                </div>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
</div>


<style>
    body {
        /* background: linear-gradient(135deg, #0f0c29, #302b63, #24243e); */
        background: url('<?php echo e(asset("images/op.jpg")); ?>') no-repeat center center fixed;
        background-size: cover;

        background-attachment: fixed;
        color: #fff;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .neon-glass-page {
        background: rgba(255, 255, 255, 0.05);
        padding: 40px 20px;
        border-radius: 20px;
        backdrop-filter: blur(15px);
        box-shadow: 0 0 30px rgba(0, 255, 204, 0.1);
    }

    .wishlist-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
    }

    .wishlist-card {
        background: rgba(255, 255, 255, 0.06);
        border-radius: 15px;
        box-shadow: 0 0 15px rgba(0, 255, 204, 0.05);
        padding: 20px;
        text-align: center;
        width: 270px;
        transition: transform 0.3s ease-in-out;
        backdrop-filter: blur(10px);
    }

    .wishlist-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0 10px #00ffd5;
    }

    .wishlist-img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 10px;
        box-shadow: 0 0 8px rgba(0, 255, 204, 0.4);
        margin-bottom: 15px;
    }

    .wishlist-icon {
        font-size: 26px;
        cursor: pointer;
        margin-top: 8px;
        transition: color 0.3s, transform 0.2s;
    }

    .wishlist-icon.far {
        color: #ccc;
    }

    .wishlist-icon.fas {
        color: red;
    }

    .wishlist-icon:hover {
        transform: scale(1.2);
    }

    .book-title {
        font-size: 20px;
        font-weight: bold;
        margin-top: 10px;
        color: #00ffd5;
    }

    .book-price {
        font-size: 18px;
        color: #28ff99;
        font-weight: bold;
        margin-top: 5px;
    }

    .wishlist-rating {
        font-size: 16px;
        font-weight: bold;
        color: #ffa500;
        margin-top: 5px;
    }

    .wishlist-date {
        font-size: 14px;
        color: #aaa;
        margin-top: 5px;
    }

    .wishlist-actions {
        margin-top: 10px;
    }

    .move-to-cart {
        background: #00bfff;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: bold;
        transition: 0.3s;
    }

    .move-to-cart:hover {
        background: #0099cc;
    }

    .btn-primary {
        display: inline-block;
        margin-top: 10px;
        padding: 8px 12px;
        background: #28a745;
        color: white;
        border-radius: 6px;
        text-decoration: none;
        font-weight: bold;
    }

    .btn-primary:hover {
        background: #1c7c36;
    }

    .alert-success {
        background: rgba(40, 255, 153, 0.1);
        color: #28ff99;
        border: 1px solid #28ff99;
        padding: 10px 15px;
        border-radius: 10px;
        margin-bottom: 20px;
        text-align: center;
    }
</style>


<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".wishlist-icon").forEach(icon => {
        icon.addEventListener("click", function () {
            const bookId = this.getAttribute("data-book-id");
            const iconEl = this;

            if (iconEl.classList.contains("fas")) {
                if (!confirm("Are you sure you want to remove this book from your wishlist?")) {
                    return;
                }
            }

            fetch("<?php echo e(route('wishlist.toggle')); ?>", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "<?php echo e(csrf_token()); ?>",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ book_id: bookId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "added") {
                    iconEl.classList.remove("far");
                    iconEl.classList.add("fas");
                } else if (data.status === "removed") {
                    iconEl.classList.remove("fas");
                    iconEl.classList.add("far");
                }
            })
            .catch(error => console.error("Error:", error));
        });
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rana Dixit\BookStore\BookStore\resources\views/wishlist.blade.php ENDPATH**/ ?>