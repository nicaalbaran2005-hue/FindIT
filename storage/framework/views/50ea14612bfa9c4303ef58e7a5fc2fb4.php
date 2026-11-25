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
            <div class="topbar-title">Item Details</div>
            <div class="topbar-sub">View item information and possible matches.</div>
        </div>
     <?php $__env->endSlot(); ?>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;align-items:start;">

        
        <div class="card" style="overflow:hidden;">
            <?php if($item->image): ?>
                <img src="<?php echo e(Storage::url($item->image)); ?>" style="width:100%;height:230px;object-fit:cover;">
            <?php else: ?>
                <div style="height:180px;background:#f1f5f9;display:flex;flex-direction:column;align-items:center;justify-content:center;gap:8px;">
                    <i class="ti ti-photo-off" style="font-size:40px;color:#cbd5e1;"></i>
                    <span style="font-size:12px;color:#cbd5e1;">No image uploaded</span>
                </div>
            <?php endif; ?>

            <div style="padding:20px;">
                <div style="display:flex;gap:6px;margin-bottom:12px;">
                    <span class="badge badge-<?php echo e($item->type); ?>"><?php echo e(strtoupper($item->type)); ?></span>
                    <span class="badge badge-<?php echo e($item->status); ?>"><?php echo e(strtoupper($item->status)); ?></span>
                </div>

                <h2 style="font-size:18px;font-weight:700;color:#0f172a;margin-bottom:16px;"><?php echo e($item->title); ?></h2>

                <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:16px;">
                    <div style="background:#f8fafc;border-radius:8px;padding:12px;">
                        <div style="font-size:11px;color:#94a3b8;margin-bottom:3px;text-transform:uppercase;letter-spacing:0.05em;">Category</div>
                        <div style="font-size:13px;font-weight:500;color:#1e293b;"><?php echo e($item->category); ?></div>
                    </div>
                    <div style="background:#f8fafc;border-radius:8px;padding:12px;">
                        <div style="font-size:11px;color:#94a3b8;margin-bottom:3px;text-transform:uppercase;letter-spacing:0.05em;">Location</div>
                        <div style="font-size:13px;font-weight:500;color:#1e293b;"><?php echo e($item->location); ?></div>
                    </div>
                    <div style="background:#f8fafc;border-radius:8px;padding:12px;">
                        <div style="font-size:11px;color:#94a3b8;margin-bottom:3px;text-transform:uppercase;letter-spacing:0.05em;">Date</div>
                        <div style="font-size:13px;font-weight:500;color:#1e293b;"><?php echo e($item->date_reported); ?></div>
                    </div>
                    <div style="background:#f8fafc;border-radius:8px;padding:12px;">
                        <div style="font-size:11px;color:#94a3b8;margin-bottom:3px;text-transform:uppercase;letter-spacing:0.05em;">Time</div>
                        <div style="font-size:13px;font-weight:500;color:#1e293b;"><?php echo e($item->time_reported); ?></div>
                    </div>
                    <div style="background:#f8fafc;border-radius:8px;padding:12px;">
                        <div style="font-size:11px;color:#94a3b8;margin-bottom:3px;text-transform:uppercase;letter-spacing:0.05em;">Reported By</div>
                        <div style="font-size:13px;font-weight:500;color:#1e293b;"><?php echo e($item->user->name); ?></div>
                    </div>
                    <div style="background:#f8fafc;border-radius:8px;padding:12px;">
                        <div style="font-size:11px;color:#94a3b8;margin-bottom:3px;text-transform:uppercase;letter-spacing:0.05em;">Status</div>
                        <div style="font-size:13px;font-weight:500;color:#1e293b;"><?php echo e(ucfirst($item->status)); ?></div>
                    </div>
                </div>

                <?php if($item->description): ?>
                    <div style="background:#f8fafc;border-radius:8px;padding:12px;">
                        <div style="font-size:11px;color:#94a3b8;margin-bottom:6px;text-transform:uppercase;letter-spacing:0.05em;">Description</div>
                        <div style="font-size:13px;color:#374151;line-height:1.6;"><?php echo e($item->description); ?></div>
                    </div>
                <?php endif; ?>

                <div style="margin-top:16px;">
                    <a href="<?php echo e(route('items.index')); ?>" class="btn btn-secondary">
                        <i class="ti ti-arrow-left"></i> Back to Items
                    </a>
                </div>
            </div>
        </div>

        
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <i class="ti ti-git-compare"></i> Possible Matches
                </div>
                <span class="text-muted"><?php echo e($matches->count()); ?> result(s)</span>
            </div>

            <div style="padding:14px;display:flex;flex-direction:column;gap:10px;">
                <?php $__empty_1 = true; $__currentLoopData = $matches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $match): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php $other = $item->type === 'lost' ? $match->foundItem : $match->lostItem; ?>

                    <div style="border:1px solid <?php echo e($match->match_level === 'high' ? '#bfdbfe' : ($match->match_level === 'possible' ? '#fed7aa' : '#e8edf3')); ?>;border-radius:10px;padding:14px;background:<?php echo e($match->match_level === 'high' ? '#f0f7ff' : ($match->match_level === 'possible' ? '#fffbf5' : '#fafafa')); ?>;">

                        <div style="display:flex;align-items:start;justify-content:space-between;margin-bottom:10px;">
                            <div style="flex:1;">
                                <span class="badge badge-<?php echo e($match->match_level); ?>"><?php echo e(strtoupper($match->match_level)); ?> MATCH</span>
                                <div style="font-size:13.5px;font-weight:600;color:#1e293b;margin-top:8px;"><?php echo e($other->title); ?></div>
                                <div style="font-size:12px;color:#64748b;margin-top:3px;display:flex;align-items:center;gap:4px;">
                                    <i class="ti ti-tag" style="font-size:12px;"></i> <?php echo e($other->category); ?>

                                    &bull;
                                    <i class="ti ti-map-pin" style="font-size:12px;"></i> <?php echo e($other->location); ?>

                                </div>
                                <div style="font-size:11px;color:#94a3b8;margin-top:2px;display:flex;align-items:center;gap:4px;">
                                    <i class="ti ti-calendar" style="font-size:11px;"></i> <?php echo e($other->date_reported); ?>

                                </div>
                            </div>
                            <div style="text-align:right;flex-shrink:0;margin-left:12px;">
                                <div style="font-size:26px;font-weight:700;color:<?php echo e($match->match_level === 'high' ? '#185FA5' : ($match->match_level === 'possible' ? '#854F0B' : '#64748b')); ?>;">
                                    <?php echo e(number_format($match->total_score, 0)); ?>%
                                </div>
                                <div style="font-size:10px;color:#94a3b8;margin-top:4px;text-align:right;line-height:1.6;">
                                    Location: <?php echo e($match->location_score); ?>%<br>
                                    Date/Time: <?php echo e($match->date_time_score); ?>%<br>
                                    Category: <?php echo e($match->category_score); ?>%
                                </div>
                            </div>
                        </div>

                        
                        <div style="background:#e2e8f0;border-radius:4px;height:5px;margin-bottom:12px;">
                            <div style="background:<?php echo e($match->match_level === 'high' ? '#185FA5' : ($match->match_level === 'possible' ? '#f97316' : '#94a3b8')); ?>;height:5px;border-radius:4px;width:<?php echo e($match->total_score); ?>%;"></div>
                        </div>

                        <div style="display:flex;gap:8px;">
                            <a href="<?php echo e(route('items.show', $other)); ?>" class="btn btn-secondary btn-sm">
                                <i class="ti ti-eye"></i> View
                            </a>

                            
                            <?php if(
                                in_array($match->match_level, ['high', 'possible'])
                                && $item->user_id === auth()->id()
                                && strtolower($item->status) !== 'claimed'
                                && strtolower($other->status) !== 'claimed'
                            ): ?>
                                <a href="<?php echo e(route('claims.create', $match)); ?>" class="btn btn-primary btn-sm">
                                    <i class="ti ti-hand-finger"></i> Claim This Item
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="empty-state">
                        <i class="ti ti-git-compare"></i>
                        <p>No matches found yet.</p>
                        <span>Matches appear when similar items are reported.</span>
                    </div>
                <?php endif; ?>
            </div>
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
<?php endif; ?><?php /**PATH C:\xampp3\htdocs\Findit1\resources\views/items/show.blade.php ENDPATH**/ ?>