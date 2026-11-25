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
            <div class="topbar-title">Notifications</div>
            <div class="topbar-sub">Your system notifications and updates.</div>
        </div>
     <?php $__env->endSlot(); ?>

    <div style="max-width:700px;margin:0 auto;">
        <div class="card" style="overflow:hidden;">
            <div class="card-header">
                <div class="card-title">
                    <i class="ti ti-bell"></i> All Notifications
                </div>
                <form method="POST" action="<?php echo e(route('notifications.readAll')); ?>">
                    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                    <button type="submit" class="btn btn-secondary btn-sm">
                        <i class="ti ti-checks"></i> Mark All as Read
                    </button>
                </form>
            </div>

            <?php if(session('success')): ?>
                <div class="alert alert-success" style="margin:14px 18px 0;">
                    <i class="ti ti-circle-check"></i> <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notif): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div style="padding:14px 18px;border-bottom:1px solid #f1f5f9;display:flex;gap:14px;align-items:flex-start;<?php echo e(!$notif->is_read ? 'background:#f8fbff;border-left:3px solid #185FA5;' : ''); ?>">
                    <div style="width:38px;height:38px;border-radius:10px;background:<?php echo e(!$notif->is_read ? '#EBF3FC' : '#f1f5f9'); ?>;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="ti ti-bell" style="font-size:18px;color:<?php echo e(!$notif->is_read ? '#185FA5' : '#94a3b8'); ?>;"></i>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div style="font-size:13.5px;font-weight:<?php echo e(!$notif->is_read ? '600' : '500'); ?>;color:#1e293b;">
                            <?php echo e($notif->title); ?>

                        </div>
                        <div style="font-size:12.5px;color:#64748b;margin-top:3px;"><?php echo e($notif->message); ?></div>
                        <div style="font-size:11px;color:#94a3b8;margin-top:4px;"><?php echo e($notif->created_at->diffForHumans()); ?></div>
                    </div>
                    <?php if(!$notif->is_read): ?>
                        <form method="POST" action="<?php echo e(route('notifications.read', $notif)); ?>">
                            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
                            <button type="submit" class="btn btn-secondary btn-sm">
                                <i class="ti ti-check"></i> Read
                            </button>
                        </form>
                    <?php else: ?>
                        <span style="font-size:11px;color:#94a3b8;white-space:nowrap;">Read</span>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="empty-state">
                    <i class="ti ti-bell-off"></i>
                    <p>No notifications yet.</p>
                    <span>You'll be notified when items match or claims are updated.</span>
                </div>
            <?php endif; ?>
        </div>
        <div style="margin-top:16px;"><?php echo e($notifications->links('vendor.pagination.custom')); ?></div>
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
<?php endif; ?><?php /**PATH C:\xampp3\htdocs\Findit1\resources\views/notifications/index.blade.php ENDPATH**/ ?>