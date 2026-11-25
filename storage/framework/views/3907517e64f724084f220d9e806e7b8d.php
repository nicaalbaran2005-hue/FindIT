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
            <div class="topbar-title">My Claims</div>
            <div class="topbar-sub">Track your claim request status.</div>
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
                <i class="ti ti-checklist"></i> Claim Requests
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Item</th>
                    <th>Match Score</th>
                    <th>Proof</th>
                    <th>Status</th>
                    <th>Admin Remarks</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $claims; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $claim): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td class="text-muted"><?php echo e($loop->iteration); ?></td>
                        <td style="font-weight:500;color:#1e293b;"><?php echo e($claim->item->title); ?></td>
                        <td>
                            <span style="font-weight:600;color:<?php echo e($claim->match->match_level === 'high' ? '#185FA5' : ($claim->match->match_level === 'possible' ? '#854F0B' : '#64748b')); ?>;">
                                <?php echo e(number_format($claim->match->total_score, 0)); ?>%
                            </span>
                            <span class="badge badge-<?php echo e($claim->match->match_level); ?>" style="margin-left:4px;">
                                <?php echo e($claim->match->match_level); ?>

                            </span>
                        </td>
                        <td style="max-width:180px;">
                            <div style="font-size:12px;color:#64748b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                                <?php echo e($claim->proof_description); ?>

                            </div>
                        </td>
                        <td><span class="badge badge-<?php echo e($claim->status); ?>"><?php echo e(strtoupper($claim->status)); ?></span></td>
                        <td style="font-size:12px;color:#64748b;"><?php echo e($claim->admin_remarks ?? '—'); ?></td>
                        <td class="text-muted"><?php echo e($claim->created_at->format('M d, Y')); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="ti ti-checklist"></i>
                                <p>No claim requests yet.</p>
                                <span>Claims appear when you request an item.</span>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <div style="margin-top:16px;"><?php echo e($claims->links('vendor.pagination.custom')); ?></div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\xampp3\htdocs\Findit1\resources\views/claims/my-claims.blade.php ENDPATH**/ ?>