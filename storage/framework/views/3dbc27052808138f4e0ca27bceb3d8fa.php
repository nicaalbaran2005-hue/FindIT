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
            <div class="topbar-title">Manage Admins</div>
            <div class="topbar-sub">Add and view administrator accounts</div>
        </div>
     <?php $__env->endSlot(); ?>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <i class="ti ti-circle-check"></i> <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-error">
            <i class="ti ti-alert-circle"></i>
            <div>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div><?php echo e($error); ?></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    <?php endif; ?>

    <div style="display:grid; grid-template-columns: 1fr 1.4fr; gap:20px; align-items:start;">

        
        <div class="card">
            <div class="card-header">
                <div class="card-title"><i class="ti ti-shield-plus"></i> Add New Admin</div>
            </div>
            <div class="card-body">
                <form method="POST" action="<?php echo e(route('admin.admins.store')); ?>">
                    <?php echo csrf_field(); ?>

                    <div class="form-group">
                        <label class="form-label" for="name">Full Name</label>
                        <input class="form-input" type="text" id="name" name="name" value="<?php echo e(old('name')); ?>" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="id_number">ID Number</label>
                        <input class="form-input" type="text" id="id_number" name="id_number" value="<?php echo e(old('id_number')); ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="contact_number">Contact Number</label>
                        <input class="form-input" type="text" id="contact_number" name="contact_number" value="<?php echo e(old('contact_number')); ?>">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="email">Email Address</label>
                        <input class="form-input" type="email" id="email" name="email" value="<?php echo e(old('email')); ?>" required>
                    </div>

                    <div class="form-group" x-data="{ show: false }">
                        <label class="form-label" for="password">Password</label>
                        <div style="position:relative;">
                            <input class="form-input" :type="show ? 'text' : 'password'"
                                   id="password" name="password" required style="padding-right:40px;">
                            <button type="button" @click="show = !show"
                                    style="position:absolute; right:10px; top:50%; transform:translateY(-50%);
                                           background:none; border:none; cursor:pointer; color:#94a3b8;"
                                    title="Show/Hide password">
                                <i class="ti" :class="show ? 'ti-eye-off' : 'ti-eye'" style="font-size:18px;"></i>
                            </button>
                        </div>
                        <div class="form-hint">Minimum of 8 characters.</div>
                    </div>

                    <div class="form-group" x-data="{ show: false }">
                        <label class="form-label" for="password_confirmation">Confirm Password</label>
                        <div style="position:relative;">
                            <input class="form-input" :type="show ? 'text' : 'password'"
                                   id="password_confirmation" name="password_confirmation" required style="padding-right:40px;">
                            <button type="button" @click="show = !show"
                                    style="position:absolute; right:10px; top:50%; transform:translateY(-50%);
                                           background:none; border:none; cursor:pointer; color:#94a3b8;"
                                    title="Show/Hide password">
                                <i class="ti" :class="show ? 'ti-eye-off' : 'ti-eye'" style="font-size:18px;"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-plus"></i> Add Admin
                    </button>
                </form>
            </div>
        </div>

        
        <div class="card">
            <div class="card-header">
                <div class="card-title"><i class="ti ti-users"></i> Current Admins</div>
                <span class="badge badge-high"><?php echo e($admins->count()); ?></span>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>ID Number</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $admins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $admin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($admin->name); ?></td>
                            <td><?php echo e($admin->email); ?></td>
                            <td><?php echo e($admin->id_number ?? '—'); ?></td>
                            <td><?php echo e($admin->created_at?->format('M d, Y')); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="4">
                                <div class="empty-state">
                                    <i class="ti ti-users"></i>
                                    <p>No admin found</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
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
<?php endif; ?><?php /**PATH C:\xampp3\htdocs\Findit1\resources\views/admin/admins/index.blade.php ENDPATH**/ ?>