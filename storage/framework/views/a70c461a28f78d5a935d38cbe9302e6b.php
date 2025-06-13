<?php $__env->startSection('styles'); ?>
<style>
    body {
        background: url('<?php echo e(asset("images/op.jpg")); ?>') no-repeat center center fixed;
        background-size: cover;
        /*    */
        font-family: 'Inter', sans-serif;
        color: #f0f0f0;
    }

    h2 {
        text-shadow: 0 0 5px #00f7ff;
        margin-bottom: 30px;
        text-align: center;
    }

    .order-card {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(14px);
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.35);
        position: relative;
        margin-bottom: 30px;
        transition: transform 0.3s ease;
        animation: floatUp 0.5s ease-in;
    }

    .order-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0 18px #00f7ff;
    }

    @keyframes floatUp {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .order-card p {
        margin-bottom: 10px;
        font-size: 16px;
    }

    .badge {
        padding: 6px 12px;
        font-size: 0.85em;
        border-radius: 20px;
        font-weight: 600;
        box-shadow: 0 0 8px rgba(255,255,255,0.1);
        text-shadow: 0 0 4px rgba(0,0,0,0.2);
    }

    .badge.pending {
        background-color: #ffc107;
        color: #000;
    }

    .badge.canceled {
        background-color: #dc3545;
    }

    .badge.completed {
        background-color: #28a745;
    }

    .badge.bg-secondary {
        background-color: #6c757d;
    }

    .order-card button {
        margin-top: 12px;
        padding: 8px 16px;
        font-size: 14px;
        border-radius: 6px;
        border: none;
        font-weight: bold;
        color: #fff;
        transition: all 0.3s ease;
        box-shadow: 0 0 8px rgba(0,247,255,0.2);
    }

    .btn-danger {
        background: rgba(220, 53, 69, 0.8);
    }

    .btn-danger:hover {
        background: rgba(220, 53, 69, 1);
        box-shadow: 0 0 12px #dc3545;
    }

    .btn-primary {
        background: rgba(0,123,255,0.8);
    }

    .btn-primary:hover {
        background: rgba(0,123,255,1);
        box-shadow: 0 0 12px #007bff;
    }

    .text-warning {
        color: #ffc107;
        font-weight: bold;
        text-shadow: 0 0 6px #ffc107;
    }

    .return-section {
        display: none;
        background: rgba(0, 247, 255, 0.1);
        backdrop-filter: blur(6px);
        border: 1px dashed #00f7ff;
        padding: 15px;
        margin-top: 15px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0,247,255,0.2);
    }

    .return-section p {
        margin: 0;
        font-weight: bold;
        color: #00f7ff;
    }

    @media (max-width: 768px) {
        .order-card {
            padding: 15px;
        }

        .order-card p {
            font-size: 14px;
        }

        .order-card button {
            font-size: 13px;
        }
    }
</style>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="container">
    <h2>My Orders</h2>

    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="order-card" id="order-card-<?php echo e($order->id); ?>">
        <p><strong>Order ID:</strong> <?php echo e($order->id); ?></p>
        <p><strong>Status:</strong>
            <span class="badge
                <?php if(strtolower($order->status) == 'pending'): ?> pending
                <?php elseif(strtolower($order->status) == 'canceled'): ?> canceled
                <?php elseif(strtolower($order->status) == 'completed'): ?> completed
                <?php else: ?> bg-secondary <?php endif; ?>">
                <?php echo e(ucfirst($order->status)); ?>

            </span>
        </p>
        <p><strong>Total:</strong> ₹<?php echo e($order->total_price); ?></p>
        <p><strong>Ordered On:</strong> <?php echo e($order->created_at->format('d M Y, H:i A')); ?></p>

        <!-- Cancel Order Button (if order is pending) -->
        <?php if(strtolower($order->status) == 'pending'): ?>
            <button class="btn btn-danger cancel-order-btn" data-id="<?php echo e($order->id); ?>">Cancel Order</button>
        <?php endif; ?>

        <!-- Return Order Button (if order is completed) -->
        <?php if(strtolower($order->status) == 'completed'): ?>
            <button class="btn btn-primary return-order-btn" data-id="<?php echo e($order->id); ?>">Return Order</button>
        <?php endif; ?>

        <!-- If order is canceled, show a payment returned message -->
        <?php if(strtolower($order->status) == 'canceled'): ?>
            <p class="text-warning mt-2">Order Canceled!</p>
        <?php endif; ?>

        <!-- Hidden return section for return orders -->
        <div class="return-section" id="return-section-<?php echo e($order->id); ?>">
            <p>Return process initiated. Order Canceled!</p>
        </div>

    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Cancel Order functionality (AJAX)
    document.querySelectorAll(".cancel-order-btn").forEach(button => {
        button.addEventListener("click", function() {
            let orderId = this.getAttribute("data-id");
            let csrfToken = "<?php echo e(csrf_token()); ?>";

            if (confirm("Are you sure you want to cancel this order?")) {
                button.textContent = "Canceling...";
                button.disabled = true;

                fetch(`/orders/${orderId}/cancel`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken,
                        "Content-Type": "application/json"
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert("Order has been canceled.");
                        location.reload(); // Reload page to update status
                    } else {
                        alert(data.error);
                        button.textContent = "Cancel Order";
                        button.disabled = false;
                    }
                })
                .catch(error => {
                    console.error("Error:", error);
                    button.textContent = "Cancel Order";
                    button.disabled = false;
                });
            }
        });
    });

    // Return Order functionality (inline reveal)
    document.querySelectorAll(".return-order-btn").forEach(button => {
        button.addEventListener("click", function() {
            let orderId = this.getAttribute("data-id");
            let returnSection = document.getElementById("return-section-" + orderId);
            if (returnSection) {
                returnSection.style.display = "block";
                returnSection.scrollIntoView({ behavior: "smooth" });
                // Optionally, change button text and disable it
                button.textContent = "Return Initiated";
                button.disabled = true;
            }
        });
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rana Dixit\BookStore\BookStore\resources\views/orders/history.blade.php ENDPATH**/ ?>