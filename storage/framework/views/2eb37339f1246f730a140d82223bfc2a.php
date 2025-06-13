<?php $__env->startSection('title', 'Admin Dashboard'); ?>
<?php $__env->startSection('scripts'); ?>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const alertBox = document.querySelector('.alert-warning');
    if (alertBox) {
      alertBox.scrollIntoView({ behavior: 'smooth' });
    }
  });
</script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
  <style>
    body {
      background: linear-gradient(145deg, #0f0f0f, #1a1a1a);
      background-attachment: fixed;
      color: #fff;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .container-fluid {
      padding: 2rem;
    }

    h2, h3 {
      font-weight: bold;
      text-shadow: 0 0 5px #00f7ff;
    }

    .stat-box {
      border-radius: 20px;
      padding: 1.5rem;
      color: #fff;
      background: rgba(0, 0, 0, 0.4);
      backdrop-filter: blur(12px);
      box-shadow: 0 0 10px rgba(0, 255, 255, 0.2);
      position: relative;
      overflow: hidden;
      transition: all .4s ease-in-out;
      border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .stat-box:hover {
      transform: translateY(-6px) scale(1.02);
      box-shadow: 0 0 20px #00f7ff;
    }

    .stat-box i {
      position: absolute;
      top: 1rem;
      right: 1rem;
      font-size: 2.5rem;
      opacity: .15;
      color: #fff;
    }
    .alert-warning {
      background: rgba(255, 193, 7, 0.1); /* Yellow with opacity */
      border: 1px solid #ffc107;
      color: #ffc107;
      backdrop-filter: blur(10px);
      border-radius: 15px;
      padding: 1rem 1.25rem;
      margin-top: 1.5rem;
      box-shadow: 0 0 12px rgba(255, 193, 7, 0.3);
      animation: pulseAlert 1.5s ease-in-out infinite;
    }

    .alert-warning ul {
      margin: 0.75rem 0 0 1rem;
    }

    .alert-warning li {
      padding: 2px 0;
      list-style-type: "⚠️ ";
    }

    @keyframes pulseAlert {
      0% { box-shadow: 0 0 5px rgba(255, 193, 7, 0.4); }
      50% { box-shadow: 0 0 20px rgba(255, 193, 7, 0.7); }
      100% { box-shadow: 0 0 5px rgba(255, 193, 7, 0.4); }
    }

    .alert-danger {
      background: rgba(220, 53, 69, 0.15);
      border: 1px solid #dc3545;
      color: #dc3545;
      backdrop-filter: blur(8px);
      border-radius: 15px;
    }

    .status-badge {
      padding: .4em .8em;
      border-radius: 12px;
      font-weight: 600;
      font-size: 0.85rem;
      display: inline-block;
    }

    .status-pending   { background: #ffc107; color: #000; }
    .status-shipped   { background: #0d6efd; color: #fff; }
    .status-delivered { background: #198754; color: #fff; }
    .status-canceled  { background: #dc3545; color: #fff; }

    .table {
      background: rgba(255, 255, 255, 0.03);
      backdrop-filter: blur(6px);
      border-radius: 12px;
      overflow: hidden;
      color: #f0f0f0;
    }

    .table th {
      background: rgba(0, 0, 0, 0.3);
      color: #00f7ff;
    }

    .btn-outline-secondary {
      border-color: #00f7ff;
      color: #00f7ff;
      transition: 0.3s ease;
    }

    .btn-outline-secondary:hover {
      background: #00f7ff;
      color: #000;
    }

    .btn-outline-primary {
      border-color: #0d6efd;
      color: #0d6efd;
    }

    .btn-outline-primary:hover {
      background: #0d6efd;
      color: #fff;
    }
  </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
  <h2 class="mb-4">📊 Admin Dashboard</h2>

  <div class="row g-4">
    <div class="col-6 col-lg-3">
      <div class="stat-box">
        <i class="bi bi-currency-rupee"></i>
        <h3>₹<?php echo e(number_format($totalRevenue,2)); ?></h3>
        <p>Total Revenue</p>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="stat-box">
        <i class="bi bi-graph-down"></i>
        <h3>₹<?php echo e(number_format($profitLoss,2)); ?></h3>
        <p>Profit / Loss</p>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="stat-box">
        <i class="bi bi-people-fill"></i>
        <h3><?php echo e($totalUsers); ?></h3>
        <p>Total Users</p>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="stat-box">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <h3><?php echo e($lowStockCount); ?></h3>
        <p>Low Stock Books</p>
      </div>
    </div>
  </div>

  <div class="row g-4 mt-3">
    <div class="col-6 col-lg-3">
      <div class="stat-box">
        <i class="bi bi-cart-fill"></i>
        <h3><?php echo e($totalOrders); ?></h3>
        <p>Total Orders</p>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="stat-box">
        <i class="bi bi-calendar-month"></i>
        <h3><?php echo e($ordersThisMonth); ?></h3>
        <p>Orders This Month</p>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="stat-box">
        <i class="bi bi-calendar2-week"></i>
        <h3><?php echo e($ordersLastMonth); ?></h3>
        <p>Last Month Orders</p>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="stat-box">
        <i class="bi bi-star-fill"></i>
        <h3><?php echo e($bestSellerTitle); ?></h3>
        <p>Best Seller</p>
      </div>
    </div>
  </div>

  <?php if($lowStockBooks->count() > 0): ?>
  <div class="alert alert-warning">
      ⚠️ Warning: <?php echo e($lowStockBooks->count()); ?> books are running low on stock!
      <ul>
          <?php $__currentLoopData = $lowStockBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li>Book Name: <?php echo e($book->title); ?> (Stock: <?php echo e($book->stock); ?>)</li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
  </div>
<?php endif; ?>

  <h3 class="mt-5">📋 Recent Orders</h3>
  <div class="table-responsive">
    <table class="table table-striped align-middle">
      <thead>
        <tr>
          <th>Order ID</th>
          <th>User</th>
          <th>Total</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td>#<?php echo e($order->id); ?></td>
            <td><?php echo e($order->user->name ?? 'Guest'); ?></td>
            <td>₹<?php echo e(number_format($order->total_price,2)); ?></td>
            <td>
              <span class="status-badge status-<?php echo e(strtolower($order->status)); ?>">
                <?php echo e(ucfirst($order->status)); ?>

              </span>
            </td>
            <td>
              <a href="<?php echo e(route('admin.orders.index',$order->id)); ?>" class="btn btn-sm btn-outline-primary">View</a>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="5" class="text-center">No recent orders.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <h3 class="mt-5">🔧 Quick Actions</h3>
  <div class="row g-3 mt-2">
    <div class="col-6 col-md-3">
      <a href="<?php echo e(route('admin.products.index')); ?>" class="btn btn-outline-secondary w-100">Manage Products</a>
    </div>
    <div class="col-6 col-md-3">
      <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-outline-secondary w-100">Manage Orders</a>
    </div>
    <div class="col-6 col-md-3">
      <a href="<?php echo e(route('admin.users')); ?>" class="btn btn-outline-secondary w-100">Manage Users</a>
    </div>
    <div class="col-6 col-md-3">
      <a href="<?php echo e(route('admin.reviews.index')); ?>" class="btn btn-outline-secondary w-100">Manage Reviews</a>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rana Dixit\BookStore\BookStore\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>