<div>

    <?php if($template == 1): ?>
        <div class="form-group mb-3">
            <label for="slug">Slug
                <?php if($required): ?>
                    <span class="text-danger" style="font-size: 20px;line-height: 1;">*</span>
                <?php endif; ?>
            </label>
            <input type="text" placeholder="Slug" name="slug" class="form-control" wire:model="slug"
                wire:change="isUnique()" <?php echo e($required ? 'required' : ''); ?>>
            <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="alert alert-danger"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
    <?php else: ?>
        <div class="form-group row">
            <label class="col-md-3 col-form-label" for="slug">Slug
                <?php if($required): ?>
                    <span class="text-danger" style="font-size: 20px;line-height: 1;">*</span>
                <?php endif; ?>
            </label>
            <div class="col-md-9">
                <input type="text" placeholder="Slug" name="slug" class="form-control"
                    wire:model="slug" wire:change="isUnique()" <?php echo e($required ? 'required' : ''); ?>>
                <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="alert alert-danger"><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>
    <?php endif; ?>

</div>
<?php /**PATH C:\wamp64\www\jisha\Medon-Laravel\resources\views/livewire/slug-check.blade.php ENDPATH**/ ?>