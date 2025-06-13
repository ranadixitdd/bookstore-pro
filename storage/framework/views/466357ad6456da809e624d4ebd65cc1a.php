<?php $__env->startSection('title', 'Order Details'); ?>


<?php $__env->startSection('styles'); ?>
  <!-- Fonts & Icons -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- NeonGlassPage Styles -->
  <style>
    body {
  background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
  background-size: 400% 400%;
  animation: gradientBG 15s ease infinite;
  color: #fff !important;
  font-family: 'Poppins', sans-serif;
}


    .content {
      padding: 3rem 1rem;
    }

    .card-glass {
  background: rgba(15, 15, 15, 0.3);
  backdrop-filter: blur(15px);
  border: 1px solid rgba(255, 255, 255, 0.1);
  border-radius: 1rem;
  box-shadow: 0 0 15px rgba(0, 247, 255, 0.3);
  color: #fff !important;
}


    .card-glass:hover {
      box-shadow: 0 0 25px rgba(0, 247, 255, 0.4);
    }

    h2 i,
    h5 i {
      color: #00f7ff;
    }

    .status-badge {
      padding: .4em .8em;
      border-radius: .5rem;
      font-weight: 600;
      font-size: .9em;
    }

    .status-pending   { background-color: #ffc107; color: #000; }
    .status-shipped   { background-color: #0dcaf0; color: #000; }
    .status-delivered { background-color: #198754; color: #fff; }
    .status-canceled  { background-color: #dc3545; color: #fff; }

    select.form-select,
    .btn {
      background-color: #0f0f0f;
      border: 1px solid #00f7ff;
      color: #00f7ff;
      transition: all 0.3s ease;
    }

    select.form-select:focus,
    .btn:focus {
      outline: none;
      box-shadow: 0 0 10px #00f7ff;
    }

    .btn-success {
      background-color: transparent;
      border-color: #00ff99;
      color: #00ff99;
    }

    .btn-success:hover {
      background-color: #00ff99;
      color: #000;
      box-shadow: 0 0 15px #00ff99;
    }

    .btn-primary {
      background-color: transparent;
      border-color: #00f7ff;
      color: #00f7ff;
    }

    .btn-primary:hover {
      background-color: #00f7ff;
      color: #000;
      box-shadow: 0 0 15px #00f7ff;
    }

    .table {
      color: #fff;
      background: rgba(255, 255, 255, 0.05);
    }
    .table th,
.table td {
  color: #fff;
  background-color: rgba(255, 255, 255, 0.05);
}

.table thead th {
  background-color: rgba(255, 255, 255, 0.1);
}

.table-bordered th,
.table-bordered td {
  border-color: rgba(255, 255, 255, 0.15);
}

h2, h5, p, address, td, th, label, select, option, .form-select, .btn {
  color: #ffffff !important;
}

  </style>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const sel = document.getElementById('statusSelect');
      if (sel) {
        sel.closest('form').addEventListener('submit', e => {
          const ns = sel.value.charAt(0).toUpperCase() + sel.value.slice(1);
          if (!confirm(`Change order status to "${ns}"?`)) e.preventDefault();
        });
      }
    });
  </script>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<div class="container content">
  <div class="card card-glass shadow-sm mb-5">
    <div class="card-body p-5">
      <h2 class="text-center mb-4">
        <i class="fas fa-file-alt me-2"></i> Order #<?php echo e($order->id); ?> Details
      </h2>

      <div class="row mb-4">
        <div class="col-md-6">
          <h5><i class="fas fa-user-circle me-2"></i>Customer</h5>
          <p><i class="fas fa-user me-2"></i><?php echo e($order->user->name); ?></p>
          <p><i class="fas fa-envelope me-2"></i><?php echo e($order->user->email); ?></p>
          <p><i class="fas fa-phone me-2"></i><?php echo e($order->user->phone ?? 'N/A'); ?></p>
        </div>
        <div class="col-md-6">
          <h5><i class="fas fa-info-circle me-2"></i>Order Info</h5>
          <p><i class="fas fa-calendar-alt me-2"></i><?php echo e($order->created_at->format('d M Y, h:i A')); ?></p>
          <p>
            <i class="fas fa-info me-2"></i>Status:
            <span class="status-badge status-<?php echo e(strtolower($order->status)); ?>">
              <?php echo e(ucfirst($order->status)); ?>

            </span>
          </p>
          <p><i class="fas fa-money-check-alt me-2"></i> Payment Status: <?php echo e(ucfirst($order->payment_status ?? 'pending')); ?></p>
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-md-6">
          <h5><i class="fas fa-location-arrow me-2"></i>Shipping Address</h5>
          <address class="ps-3 border-start border-3 border-info">
            <?php echo e($order->shipping_address); ?>

          </address>
        </div>
        <div class="col-md-6">
          <h5><i class="fas fa-credit-card me-2"></i>Payment Method</h5>
          <p><?php echo e(ucfirst($order->payment_method)); ?></p>
        </div>
      </div>

      <h5 class="mb-3"><i class="fas fa-box me-2"></i>Items</h5>
      <div class="table-responsive mb-4">
        <table class="table table-bordered align-middle mb-0">
          <thead>
            <tr>
              <th>Book</th>
              <th class="text-center">Qty</th>
              <th class="text-end">Price</th>
              <th class="text-end">Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
              <td><?php echo e($item->book->name); ?></td>
              <td class="text-center"><?php echo e($item->quantity); ?></td>
              <td class="text-end">₹<?php echo e(number_format($item->price,2)); ?></td>
              <td class="text-end">₹<?php echo e(number_format($item->price*$item->quantity,2)); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
          <tfoot>
            <tr>
              <th colspan="3" class="text-end">Total</th>
              <th class="text-end">₹<?php echo e(number_format($order->total_price,2)); ?></th>
            </tr>
          </tfoot>
        </table>
      </div>

      <h5 class="mb-3"><i class="fas fa-sync-alt me-2"></i>Update Status</h5>
      <form
        action="<?php echo e(route('admin.orders.update',$order->id)); ?>"
        method="POST"
        class="row g-2 align-items-center mb-4"
      >
        <?php echo csrf_field(); ?>
        <div class="col-auto">
          <select id="statusSelect" name="status" class="form-select">
            <option value="pending"   <?php echo e($order->status==='pending'?   'selected':''); ?>>Pending</option>
            <option value="shipped"   <?php echo e($order->status==='shipped'?   'selected':''); ?>>Shipped</option>
            <option value="delivered" <?php echo e($order->status==='delivered'? 'selected':''); ?>>Delivered</option>
            <option value="canceled"  <?php echo e($order->status==='canceled'?  'selected':''); ?>>Canceled</option>
          </select>
        </div>
        <div class="col-auto">
          <button class="btn btn-success">
            <i class="fas fa-check me-1"></i> Update
          </button>
        </div>
      </form>

      <a href="<?php echo e(route('admin.orders.index')); ?>" class="btn btn-primary">
        <i class="fas fa-arrow-left me-1"></i> Back to Orders
      </a>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Rana Dixit\BookStore\BookStore\resources\views/admin/orders/view.blade.php ENDPATH**/ ?>