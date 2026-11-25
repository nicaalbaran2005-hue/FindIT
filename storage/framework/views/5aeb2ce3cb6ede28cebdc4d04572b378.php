<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div>
            <div class="topbar-title">Admin Dashboard</div>
            <div class="topbar-sub">System overview — CTU Tuburan Campus</div>
        </div>
     <?php $__env->endSlot(); ?>

    
    <div class="stat-grid" style="grid-template-columns:repeat(3,1fr);">
        <div class="stat-card">
            <div class="stat-icon" style="background:#EBF3FC;">
                <i class="ti ti-users" style="color:#185FA5;"></i>
            </div>
            <div>
                <div class="stat-label">Total Users</div>
                <div class="stat-value"><?php echo e($totalUsers); ?></div>
                <div class="stat-hint">Registered students & staff</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#FCEBEB;">
                <i class="ti ti-alert-circle" style="color:#A32D2D;"></i>
            </div>
            <div>
                <div class="stat-label">Lost Items</div>
                <div class="stat-value"><?php echo e($totalLost); ?></div>
                <div class="stat-hint">Active reports</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#EAF3DE;">
                <i class="ti ti-circle-check" style="color:#3B6D11;"></i>
            </div>
            <div>
                <div class="stat-label">Found Items</div>
                <div class="stat-value"><?php echo e($totalFound); ?></div>
                <div class="stat-hint">Active reports</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#EEEDFE;">
                <i class="ti ti-package" style="color:#534AB7;"></i>
            </div>
            <div>
                <div class="stat-label">Total Items</div>
                <div class="stat-value"><?php echo e($totalItems); ?></div>
                <div class="stat-hint">All reported items</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#FAEEDA;">
                <i class="ti ti-clock" style="color:#854F0B;"></i>
            </div>
            <div>
                <div class="stat-label">Pending Claims</div>
                <div class="stat-value"><?php echo e($pendingClaims); ?></div>
                <div class="stat-hint">Awaiting review</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#E1F5EE;">
                <i class="ti ti-git-compare" style="color:#0F6E56;"></i>
            </div>
            <div>
                <div class="stat-label">High Matches</div>
                <div class="stat-value"><?php echo e($highMatches); ?></div>
                <div class="stat-hint">Score >= 70%</div>
            </div>
        </div>
    </div>

    
    <div class="action-grid" style="grid-template-columns:repeat(4,1fr);">
        <a href="<?php echo e(route('admin.users')); ?>" class="action-card">
            <div class="action-icon" style="background:#EBF3FC;">
                <i class="ti ti-users" style="color:#185FA5;"></i>
            </div>
            <div>
                <div class="action-label">Users</div>
                <div class="action-sub"><?php echo e($totalUsers); ?> registered</div>
            </div>
        </a>
        <a href="<?php echo e(route('admin.items')); ?>" class="action-card">
            <div class="action-icon" style="background:#EEEDFE;">
                <i class="ti ti-package" style="color:#534AB7;"></i>
            </div>
            <div>
                <div class="action-label">Items</div>
                <div class="action-sub"><?php echo e($totalItems); ?> total</div>
            </div>
        </a>
        <a href="<?php echo e(route('admin.claims')); ?>" class="action-card">
            <div class="action-icon" style="background:#FAEEDA;">
                <i class="ti ti-checklist" style="color:#854F0B;"></i>
            </div>
            <div>
                <div class="action-label">Claims</div>
                <div class="action-sub"><?php echo e($pendingClaims); ?> pending</div>
            </div>
        </a>
        <a href="<?php echo e(route('admin.matches')); ?>" class="action-card">
            <div class="action-icon" style="background:#E1F5EE;">
                <i class="ti ti-git-compare" style="color:#0F6E56;"></i>
            </div>
            <div>
                <div class="action-label">Matches</div>
                <div class="action-sub"><?php echo e($highMatches); ?> high</div>
            </div>
        </a>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\xampp3\htdocs\Findit1\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>