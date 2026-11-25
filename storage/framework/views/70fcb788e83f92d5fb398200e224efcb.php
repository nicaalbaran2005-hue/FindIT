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
            <div class="topbar-title">My Items</div>
            <div class="topbar-sub">All items you have reported.</div>
        </div>
     <?php $__env->endSlot(); ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <i class="ti ti-circle-check"></i> <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="card" style="overflow:hidden;">
        <div class="card-header">
            <div class="card-title">
                <i class="ti ti-bookmark"></i> Reported Items
            </div>
            <a href="<?php echo e(route('items.create')); ?>" class="btn btn-primary btn-sm">
                <i class="ti ti-plus"></i> Report Item
            </a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Type</th>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Location</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-muted"><?php echo e($loop->iteration); ?></td>
                        <td><span class="badge badge-<?php echo e($item->type); ?>"><?php echo e(strtoupper($item->type)); ?></span></td>
                        <td style="font-weight:500;color:#1e293b;"><?php echo e($item->title); ?></td>
                        <td><?php echo e($item->category); ?></td>
                        <td><?php echo e($item->location); ?></td>
                        <td class="text-muted"><?php echo e($item->date_reported); ?></td>
                        <td><span class="badge badge-<?php echo e($item->status); ?>"><?php echo e(strtoupper($item->status)); ?></span></td>
                        <td>
                            <a href="<?php echo e(route('items.show', $item)); ?>" class="btn btn-secondary btn-sm">
                                <i class="ti ti-eye"></i> View
                            </a>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="ti ti-package-off"></i>
                                <p>No items reported yet.</p>
                                <span>Start by reporting a lost or found item.</span>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div style="margin-top:16px;"><?php echo e($items->links('vendor.pagination.custom')); ?></div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\xampp3\htdocs\Findit1\resources\views/items/my-items.blade.php ENDPATH**/ ?>