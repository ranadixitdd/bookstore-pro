<?php $__env->startSection('title', $product->title . ' - Book Details'); ?>

<?php $__env->startSection('content'); ?>

<!-- ========================================================== -->
<!-- 🌟 BOOK DETAILS PAGE JAVASCRIPT -->
<!-- ========================================================== -->
<script>
document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".wishlist-icon").forEach(icon => {
                icon.addEventListener("click", function () {
            let bookId = this.getAttribute("data-book-id");

            // Send AJAX request to toggle wishlist
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
                    if (data.status === "unauthorized") {
                        // Show login prompt if user is not logged in
                Swal.fire({
                    title: 'Please Login First',
                    text: 'You need to log in to add items to your wishlist.',
                    icon: 'warning',
                    confirmButtonText: 'Login',
                    showCancelButton: true,
                    cancelButtonText: 'Cancel',
                    background: '#f8f9fa',
                    color: '#333',
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "<?php echo e(route('login')); ?>";
                    }
                });
                } else if (data.status === "added") {
                        // Update the icon to show the item is in the wishlist
                        icon.classList.remove("far");
                        icon.classList.add("fas");
                        document.getElementById("wishlist-count").textContent++;
                    } else if (data.status === "removed") {
                        // Update the icon to show the item is removed from the wishlist
                        icon.classList.remove("fas");
                        icon.classList.add("far");
                        document.getElementById("wishlist-count").textContent--;
                    }
                })
                .catch(error => console.error("Error:", error));
        });
    });
});
</script>

<!-- ========================================================== -->
<!-- 🌟 CUSTOM STYLING -->
<!-- ========================================================== -->
<style>

    /* General Page Styling */
    body {
        background: url('<?php echo e(asset("images/op.jpg")); ?>') no-repeat center center fixed !important;
        background-size: cover !important;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    color: #000;
}

.container {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

    h2 {
        font-size: 28px;
        color: #333;
        margin-bottom: 20px;
        text-align: center;
    }
    .book-image {
        width: 100%;
        max-width: 300px;
        border-radius: 5px;
        margin: 0 auto 20px;
        display: block;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
    }
    .book-image:hover {
        transform: scale(1.05);
    }
    .book-details {
        text-align: center;
    }
    .price {
        font-size: 24px;
        font-weight: bold;
        color: #28a745;
        margin: 10px 0;
    }
    .btn {
        padding: 12px 20px;
        text-decoration: none;
        border-radius: 5px;
        font-weight: bold;
        display: inline-block;
        transition: 0.3s;
        margin-top: 10px;
        border: none;
        cursor: pointer;
    }
    .btn-add-cart {
        background: #007bff;
        color: white;
    }
    .btn-add-cart:hover {
        background: #0056b3;
    }
    .btn-buy-now {
        background: #28a745;
        color: white;
    }
    .btn-buy-now:hover {
        background: #218838;
    }
    .star {
        color: gold;
        font-size: 18px;
    }
    .wishlist-icon {
        font-size: 24px;
        cursor: pointer;
        color: #dc3545;
        transition: transform 0.2s ease-in-out;
        margin-left: 10px;
    }
    .wishlist-icon:hover {
        transform: scale(1.3);
    }
    /* Shared Quantity Selector Styling */
    .quantity-selector {
        display: inline-flex;
        align-items: center;
        border: 1px solid #ccc;
        border-radius: 5px;
        overflow: hidden;
        margin-bottom: 10px;
    }
    .quantity-selector .quantity-btn {
        background: #f1f1f1;
        border: none;
        padding: 8px 12px;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.2s;
    }
    .quantity-selector .quantity-btn:hover {
        background: #e2e2e2;
    }
    .quantity-selector .quantity-input {
        width: 50px;
        text-align: center;
        border: none;
        font-size: 16px;
        outline: none;
    }
    /* Reviews Section Styling */
    .reviews {
        margin-top: 30px;
        border-top: 2px solid #ddd;
        padding-top: 20px;
    }
    .review {
        margin-bottom: 20px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background: #f9f9f9;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .review p {
        margin: 5px 0;
    }
    /* Related Books Section Styling */
    .related-books {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        justify-content: center;
        margin-top: 30px;
    }
    .related-book {
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        text-align: center;
        transition: 0.3s;
        background: #fff;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        width: 200px;
    }
    .related-book:hover {
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    }
    .related-book img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 5px;
    }
    .related-book .price {
        font-size: 18px;
        font-weight: bold;
        color: #28a745;
        margin: 5px 0;
    }
    .related-book .star {
        font-size: 16px;
    }
    .small {
        font-size: 14px;
        color: #555;
    }
</style>

<!-- ========================================================== -->
<!-- 🌟 BOOK DETAILS CONTAINER -->
<!-- ========================================================== -->
<div class="container">
    <h2><?php echo e($product->title); ?></h2>

    <!-- Book Image -->
    <img src="<?php echo e(asset('images/' . $product->image)); ?>" class="book-image" alt="<?php echo e($product->title); ?>">

    <div class="book-details">
        <!-- Book Information -->
        <p><strong>Author:</strong> <?php echo e($product->author); ?></p>
        <p class="price">₹<?php echo e(number_format($product->price, 2)); ?></p>
        <p><strong>Status:</strong> <?php echo e($product->stock > 0 ? 'In Stock' : 'Out of Stock'); ?></p>
        <p><strong>Description:</strong> <?php echo e($product->description); ?></p>

        <!-- Book Rating -->
        <?php if($product->reviews->count() > 0): ?>
            <p><strong>Rating:</strong>
                <?php for($i = 1; $i <= 5; $i++): ?>
                    <span class="star"><?php echo e($i <= round($product->averageRating) ? '★' : '☆'); ?></span>
                <?php endfor; ?>
                (<?php echo e($product->reviews->count()); ?> reviews)
            </p>
        <?php else: ?>
            <p>No reviews yet.</p>
        <?php endif; ?>

        <!-- Wishlist Count Display -->
        <p><strong>Wishlisted by:</strong> <span id="wishlist-count"><?php echo e($product->wishlist_count); ?></span> users</p>

        <!-- Action Buttons -->
        <form action="<?php echo e(route('cart.add', $product->id)); ?>" method="POST" style="display: inline-block; vertical-align: middle;">
            <?php echo csrf_field(); ?>

            <button type="submit" class="btn btn-add-cart">🛒 Add to Cart</button>
        </form>
        <form action="<?php echo e(route('buynow', $product->id)); ?>" method="POST" style="display: inline-block; vertical-align: middle;">
            <?php echo csrf_field(); ?>

            <button type="submit" class="btn btn-buy-now">🛍️ Buy Now</button>
        </form>

        <i class="fa-heart wishlist-icon <?php echo e($product->wishlisted ? 'fas' : 'far'); ?>" data-book-id="<?php echo e($product->id); ?>"></i>
    </div>
</div>

<!-- ========================================================== -->
<!-- 🌟 REVIEWS SECTION -->
<!-- ========================================================== -->
<?php if($product->approvedReviews->count()): ?>
<div class="container reviews">
    <h3>🗣️ User Reviews</h3>
    <?php $__currentLoopData = $product->approvedReviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="review">
            <strong><?php echo e($review->user->name ?? 'Anonymous'); ?></strong>
            <p class="text-yellow-500">
                <?php for($i = 1; $i <= 5; $i++): ?>
                    <i class="fa<?php echo e($i <= $review->rating ? 's' : 'r'); ?> fa-star"></i>
                <?php endfor; ?>
            </p>
            <p><?php echo e($review->comment); ?></p>
            <p class="small"><?php echo e($review->created_at->diffForHumans()); ?></p>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php else: ?>
<p class="container reviews small">No reviews yet. Be the first to leave one!</p>
<?php endif; ?>


<!-- ========================================================== -->
<!-- 🌟 ADD REVIEW FORM (Interactive Star Rating) -->
<!-- ========================================================== -->
<?php if(auth()->check()): ?>
    <div class="container reviews">
        <h3>📝 Leave a Review</h3>
        <form action="<?php echo e(route('review.store', $product->id)); ?>" method="POST" id="review-form">
            <?php echo csrf_field(); ?>
            <div class="rating-input">
                <label>Rating:</label>
                <div class="stars">
                    <span data-value="1" class="star">☆</span>
                    <span data-value="2" class="star">☆</span>
                    <span data-value="3" class="star">☆</span>
                    <span data-value="4" class="star">☆</span>
                    <span data-value="5" class="star">☆</span>
                </div>
                <input type="hidden" name="rating" id="rating" value="0" required>
            </div>
            <div class="review-content">
                <label for="content">Review:</label>
                <textarea name="content" rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-add-cart">Submit Review</button>
        </form>
    </div>
<?php else: ?>
    <p class="container reviews">⚠️ <a href="<?php echo e(route('login')); ?>">Log in</a> to leave a review.</p>
<?php endif; ?>

<!-- ========================================================== -->
<!-- 🌟 INTERACTIVE STAR RATING SCRIPT -->
<!-- ========================================================== -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    let stars = document.querySelectorAll("#review-form .stars .star");
    stars.forEach(star => {
        star.addEventListener("click", function() {
            let rating = this.getAttribute("data-value");
            document.getElementById("rating").value = rating;
            stars.forEach(s => {
                if (s.getAttribute("data-value") <= rating) {
                    s.textContent = '★';
                } else {
                    s.textContent = '☆';
                }
            });
        });
    });

    // Also update hidden fields when shared quantity changes (if not already updated)
    const sharedQty = document.getElementById('shared-quantity');
    const cartHidden = document.getElementById('cart-quantity-field');
    const buynowHidden = document.getElementById('buynow-quantity-field');
    const cartHiddenInput = document.getElementById('cart-quantity-hidden');
    const buynowHiddenInput = document.getElementById('buynow-quantity-hidden');

    function updateAllFields(val) {
        cartHidden.value = val;
        buynowHidden.value = val;
        cartHiddenInput.value = val;
        buynowHiddenInput.value = val;
    }

    sharedQty.addEventListener('input', function() {
        let val = parseInt(this.value) || 1;
        if(val < 1) val = 1;
        this.value = val;
        updateAllFields(val);
    });
});

</script>

<!-- ========================================================== -->
<!-- 🌟 INTERACTIVE STAR RATING STYLING -->
<!-- ========================================================== -->

<style>
    /* General Page Styling */
body {
    background: linear-gradient(135deg, #cfd9df 0%, #e2ebf0 100%);
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Glassmorphic Container */
.container {
    max-width: 1100px;
    margin: 30px auto;
    padding: 30px;
    border-radius: 20px;
    background: rgba(255, 255, 255, 0.15);
    box-shadow: 0 8px 32px rgba(31, 38, 135, 0.2);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: #000;
}

/* Title */
h2, h3 {
    text-align: center;
    color: #000;
}

/* Book Image */
.book-image {
    width: 100%;
    max-width: 300px;
    border-radius: 12px;
    margin: 0 auto 20px;
    display: block;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease-in-out;
}
.book-image:hover {
    transform: scale(1.05);
}

/* Book Details */
.book-details {
    text-align: center;
}
.price {
    font-size: 24px;
    font-weight: bold;
    color: #28a745;
    margin: 10px 0;
}

/* Buttons */
.btn {
    padding: 12px 20px;
    border-radius: 10px;
    font-weight: bold;
    margin-top: 10px;
    border: none;
    cursor: pointer;
    transition: 0.3s;
    backdrop-filter: blur(5px);
}
.btn-add-cart {
    background: rgba(0, 123, 255, 0.6);
    color: white;
}
.btn-add-cart:hover {
    background: rgba(0, 123, 255, 0.9);
}
.btn-buy-now {
    background: rgba(40, 167, 69, 0.6);
    color: white;
}
.btn-buy-now:hover {
    background: rgba(40, 167, 69, 0.9);
}

/* Wishlist Icon */
.wishlist-icon {
    font-size: 24px;
    cursor: pointer;
    color: #dc3545;
    transition: transform 0.2s ease-in-out;
    margin-left: 10px;
}
.wishlist-icon:hover {
    transform: scale(1.3);
}

/* Quantity Selector */
.quantity-selector {
    display: inline-flex;
    align-items: center;
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 10px;
    background: rgba(255, 255, 255, 0.2);
    border: 1px solid rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(5px);
}
.quantity-btn {
    background: rgba(255, 255, 255, 0.3);
    padding: 8px 12px;
    font-size: 16px;
    cursor: pointer;
    border: none;
}
.quantity-btn:hover {
    background: rgba(255, 255, 255, 0.5);
}
.quantity-input {
    width: 50px;
    text-align: center;
    border: none;
    font-size: 16px;
    background: transparent;
    color: #000;
}

/* Review Box */

/* ✨ USER REVIEWS GLASSMORPHIC STYLE ✨ */
.review {
    margin-bottom: 20px;
    padding: 20px;
    border-radius: 15px;
    background: rgba(255, 255, 255, 0.15);
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.3);
    color: #000;
    transition: transform 0.2s ease, box-shadow 0.3s ease;
}
.review:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.2);
}
.review strong {
    font-size: 16px;
    font-weight: bold;
    color: #111;
}
.review .fa-star {
    color: #facc15; /* Tailwind yellow-400 */
    margin-right: 2px;
}
.review p {
    margin: 8px 0;
    color: #222;
}
.review .text-xs {
    font-size: 12px;
    color: #555;
}


/* Star Rating Styles */
.star {
    color: #ffc107;
    font-size: 20px;
}
.rating-input .stars {
    display: inline-block;
    margin-left: 10px;
}
.rating-input .star {
    font-size: 24px;
    cursor: pointer;
    transition: color 0.2s;
    color: #ffc107; /* Gold color for stars */
    margin-right: 5px;
}
.rating-input .star:hover {
    transform: scale(1.2);
}
.review-content label {
    display: block;
    margin-top: 15px;
    margin-bottom: 5px;
    font-weight: bold;
}
textarea {
    width: 100%;
    padding: 10px;
    border-radius: 10px;
    border: 1px solid #ccc;
    resize: vertical;
    background: rgba(255, 255, 255, 0.3);
    backdrop-filter: blur(5px);
    color: #000;
}
    .rating-input .stars {
        display: inline-block;
        margin-left: 10px;
    }
    .rating-input .star {
        font-size: 24px;
        cursor: pointer;
        transition: color 0.2s;
        color: #ffc107; /* Gold color for stars */
        margin-right: 5px;
    }
    .rating-input .star:hover {
        transform: scale(1.2);
    }
    .review-content label {
        display: block;
        margin-top: 15px;
        margin-bottom: 5px;
        font-weight: bold;
    }
    h3.text-xl {
    font-size: 24px;
    color: #111;
    margin-bottom: 20px;
}

</style>

<!-- ========================================================== -->
<!-- 🌟 RELATED BOOKS SECTION -->
<!-- ========================================================== -->
<?php if(isset($relatedBooks) && $relatedBooks->count() > 0): ?>
    <div class="container">
        <h3>📚 Related Books</h3>
        <div class="related-books <?php echo e($relatedBooks->count() == 1 ? 'single-related' : ''); ?>">
            <?php $__currentLoopData = $relatedBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="related-book">
                    <img src="<?php echo e(asset('images/' . $related->image)); ?>" alt="<?php echo e($related->title); ?>">
                    <p><strong><?php echo e($related->title); ?></strong></p>
                    <p class="small">by <?php echo e($related->author); ?></p>
                    <p class="price">₹<?php echo e(number_format($related->price, 2)); ?></p>

                    <?php
                        $avgRating = $related->reviews->count() ? round($related->reviews->avg('rating'), 1) : 0;
                    ?>
                    <p class="rating">
                        <?php for($i = 1; $i <= 5; $i++): ?>
                            <span class="star"><?php echo e($i <= $avgRating ? '★' : '☆'); ?></span>
                        <?php endfor; ?>
                        (<?php echo e($related->reviews->count()); ?> reviews)
                    </p>
                    <a href="<?php echo e(route('products.details', $related->id)); ?>" class="btn btn-add-cart">View Book</a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rana Dixit\BookStore\BookStore\resources\views/products/details.blade.php ENDPATH**/ ?>