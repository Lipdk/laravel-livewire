<?php if(session()->has('success')): ?>
    <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md my-3" role="alert">
        <div class="flex">
            <div>
                <p class="text-sm"><?php echo e(session('success')); ?></p>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if(session()->has('error')): ?>
    <div class="bg-red-100 border-t-4 border-red-500 rounded-b text-red-900 px-4 py-3 shadow-md my-3" role="alert">
        <div class="flex">
            <div>
                <p class="text-sm"><?php echo e(session('error')); ?></p>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if(session()->has('info')): ?>
    <div class="bg-blue-100 border-t-4 border-blue-500 rounded-b text-blue-900 px-4 py-3 shadow-md my-3" role="alert">
        <div class="flex">
            <div>
                <p class="text-sm"><?php echo e(session('info')); ?></p>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /var/www/html/resources/views/flash-message.blade.php ENDPATH**/ ?>