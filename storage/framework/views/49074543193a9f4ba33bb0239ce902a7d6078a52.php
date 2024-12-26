

<?php $__env->startSection('content'); ?>
    <div class="h-100 bg-cover bg-center py-5 d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-xl-4 mx-auto">
                    <div class="card text-left">
                        <div class="card-body">
                            <div class="mb-5 text-center">
                                <img src="<?php echo e(static_asset('assets/img/logo.png')); ?>" class="mw-100 mb-4" height="70">
                                <h1 class="h3 text-primary mb-0">Welcome to Medon</h1>
                                <p>Login to your account.</p>
                            </div>
                            <form class="pad-hor" method="POST" role="form" action="<?php echo e(route('admin.login')); ?>">
                                <?php echo csrf_field(); ?>

                                <?php $__errorArgs = ['login'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <span class="invalid-feedback d-block" style="font-size: 14px" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                                <div class="form-group">
                                    <input id="email" type="email"
                                        class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" name="email"
                                        value="<?php echo e(old('email')); ?>" required autofocus placeholder="Email">
                                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback d-block" style="font-size: 14px" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="form-group">
                                    <input id="password" type="password"
                                        class="form-control<?php echo e($errors->has('password') ? ' is-invalid' : ''); ?>"
                                        name="password" required placeholder="Password">
                                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <span class="invalid-feedback d-block" style="font-size: 14px" role="alert">
                                            <strong><?php echo e($message); ?></strong>
                                        </span>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-6">
                                        <div class="text-left">
                                            <label class="aiz-checkbox">
                                                <input type="checkbox" name="remember" id="remember"
                                                    <?php echo e(old('remember') ? 'checked' : ''); ?>>
                                                <span>Remember Me</span>
                                                <span class="aiz-square-check"></span>
                                            </label>
                                        </div>
                                    </div>
                                    <?php if(env('MAIL_USERNAME') != null && env('MAIL_PASSWORD') != null): ?>
                                        
                                    <?php endif; ?>
                                </div>

                                

                                <?php if($errors->has('g-recaptcha-response')): ?>
                                    <span class="invalid-feedback d-block" style="font-size: 14px" role="alert">
                                        <strong><?php echo e($errors->first('g-recaptcha-response')); ?></strong>
                                    </span>
                                <?php endif; ?>

                                <button type="submit" class="btn btn-primary btn-lg btn-block mt-2">
                                    Login
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('header'); ?>
    <?php echo NoCaptcha::renderJs(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('backend.layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\jisha\Medon-Laravel\resources\views/backend/auth/login.blade.php ENDPATH**/ ?>