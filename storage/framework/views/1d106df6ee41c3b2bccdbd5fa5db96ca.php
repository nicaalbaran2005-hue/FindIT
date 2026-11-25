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
            <div class="topbar-title">Match Results</div>
            <div class="topbar-sub">All computed match scores between lost and found items.</div>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="card" style="overflow:hidden;">
        <div class="card-header">
            <div class="card-title">
                <i class="ti ti-git-compare"></i> Match Results
            </div>
            <span class="text-muted"><?php echo e($matches->total()); ?> total</span>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Lost Item</th>
                    <th>Found Item</th>
                    <th>Location</th>
                    <th>Date/Time</th>
                    <th>Category</th>
                    <th>Total Score</th>
                    <th>Level</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $matches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-muted"><?php echo e($loop->iteration); ?></td>
                        <td>
                            <div style="font-size:13px;font-weight:500;color:#1e293b;"><?php echo e($match->lostItem->title); ?></div>
                            <div style="font-size:11px;color:#94a3b8;"><?php echo e($match->lostItem->user->name); ?></div>
                        </td>
                        <td>
                            <div style="font-size:13px;font-weight:500;color:#1e293b;"><?php echo e($match->foundItem->title); ?></div>
                            <div style="font-size:11px;color:#94a3b8;"><?php echo e($match->foundItem->user->name); ?></div>
                        </td>
                        <td>
                            <div style="font-size:13px;font-weight:600;color:#1e293b;"><?php echo e($match->location_score); ?>%</div>
                        </td>
                        <td>
                            <div style="font-size:13px;font-weight:600;color:#1e293b;"><?php echo e($match->date_time_score); ?>%</div>
                        </td>
                        <td>
                            <div style="font-size:13px;font-weight:600;color:#1e293b;"><?php echo e($match->category_score); ?>%</div>
                        </td>
                        <td>
                            <div style="font-size:16px;font-weight:700;color:<?php echo e($match->match_level === 'high' ? '#185FA5' : ($match->match_level === 'possible' ? '#854F0B' : '#64748b')); ?>;">
                                <?php echo e(number_format($match->total_score, 0)); ?>%
                            </div>
                        </td>
                        <td>
                            <span class="badge badge-<?php echo e($match->match_level); ?>">
                                <?php echo e(strtoupper($match->match_level)); ?>

                            </span>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="ti ti-git-compare"></i>
                                <p>No match results yet.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div style="margin-top:16px;"><?php echo e($matches->links('vendor.pagination.custom')); ?></div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\xampp3\htdocs\Findit1\resources\views/admin/matches.blade.php ENDPATH**/ ?>