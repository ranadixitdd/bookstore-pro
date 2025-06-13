<?php $__env->startSection('title', 'Checkout'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .container {
        max-width: 900px;
        margin: auto;
        background: white;
        padding: 25px;
        border-radius: 8px;
        box-shadow: 0px 0px 12px rgba(0, 0, 0, 0.1);
    }
    h2 {
        text-align: center;
        font-size: 26px;
        color: #2C3E50;
        margin-bottom: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    th, td {
        padding: 12px;
        text-align: left;
        border: 1px solid #ddd;
    }
    th {
        background-color: #2C3E50;
        color: white;
        font-size: 16px;
    }
    td {
        font-size: 14px;
    }
    input, select, textarea {
        width: 100%;
        padding: 10px;
        margin-top: 10px;
        border-radius: 5px;
        border: 1px solid #ccc;
        font-size: 14px;
    }
    textarea {
        height: 80px;
    }
    .btn {
        display: inline-block;
        padding: 12px 15px;
        text-decoration: none;
        border-radius: 6px;
        font-weight: bold;
        transition: 0.3s;
        font-size: 16px;
        border: none;
        cursor: pointer;
    }
    .btn-place-order {
        background: #28a745;
        color: white;
        width: 100%;
        text-align: center;
    }
    .btn-place-order:hover {
        background: #218838;
    }
    .btn-back {
        background: #007bff;
        color: white;
        display: inline-block;
        margin-top: 10px;
    }
    .btn-back:hover {
        background: #0056b3;
    }
    .error {
        color: red;
        font-size: 14px;
        margin-top: 5px;
    }
</style>

<div class="container">
    <h2>🛍️ Checkout</h2>
    <?php if(isset($buyNowProduct)): ?>
    <!-- Display Buy Now Product -->
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php echo e($buyNowProduct->title); ?></td>
                <td>₹<?php echo e(number_format($buyNowProduct->price, 2)); ?></td>
                <td>
                    <input type="number" name="quantity" value="1" min="1" max="<?php echo e($buyNowProduct->stock); ?>">
                </td>
                <td>₹<?php echo e(number_format($buyNowProduct->price, 2)); ?></td>
            </tr>
        </tbody>
    </table>

    <?php elseif(session('cart') && count(session('cart')) > 0): ?>
        <!-- Display Cart Items -->
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $total = 0; ?>
                <?php $__currentLoopData = session('cart'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $id => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $total += $item['price'] * $item['quantity']; ?>
                    <tr>
                        <td><?php echo e($item['name']); ?></td>
                        <td>₹<?php echo e(number_format($item['price'], 2)); ?></td>
                        <td><?php echo e($item['quantity']); ?></td>
                        <td>₹<?php echo e(number_format($item['price'] * $item['quantity'], 2)); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td colspan="3"><strong>Total:</strong></td>
                    <td><strong>₹<?php echo e(number_format($total, 2)); ?></strong></td>
                </tr>
            </tbody>
        </table>
    <?php else: ?>
        <p style="text-align: center; font-size: 18px;">Your cart is empty.</p>
        <a href="<?php echo e(route('products.list')); ?>" class="btn btn-back">⬅️ Continue Shopping</a>
        <?php return; ?>
    <?php endif; ?>

    <h3 style="margin-top: 25px;">📋 Shipping Details</h3>
    <form action="<?php echo e(route('checkout.process')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" value="<?php echo e(old('name', auth()->user()->name)); ?>" required>
        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <label for="address">Shipping Address</label>
        <textarea id="address" name="address" required><?php echo e(old('address', auth()->user()->address)); ?></textarea>
        <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <label for="payment_method">Payment Method</label>
        <select id="payment_method" name="payment_method" required>
            <option value="Cash on Delivery">Cash on Delivery</option>
        </select>
        <?php $__errorArgs = ['payment_method'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <p class="error"><?php echo e($message); ?></p> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

        <button type="submit" class="btn btn-place-order">✅ Place Order</button>
    </form>
    <a href="<?php echo e(route('cart.view')); ?>" class="btn btn-back">⬅️ Back to Cart</a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rana Dixit\BookStore\BookStore\resources\views/checkout/index.blade.php ENDPATH**/ ?>