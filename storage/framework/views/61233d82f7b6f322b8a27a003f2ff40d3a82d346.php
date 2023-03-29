<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg px-4 py-4">
            <?php echo $__env->make('flash-message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <button wire:click="create()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">New Category</button>

            <?php if($isOpen): ?>
                <?php echo $__env->make('livewire.create', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

            <table class="w-full">
                <thead>
                <tr class="bg-gray-100">
                    <th class="px-4 py-2 w-12">#</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Description</th>
                    <th class="px-4 py-2">Image</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if(count($categories) > 0): ?>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="border px-4 py-2"><?php echo e($category->id); ?></td>
                            <td class="border px-4 py-2"><?php echo e($category->name); ?></td>
                            <td class="border px-4 py-2 text-xs"><?php echo e($category->description); ?></td>
                            <td class="border px-4 py-2"><?php echo e($category->image); ?></td>
                            <td class="border px-4 py-2 w-20 text-center">
                                <?php if($category->status == 1): ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-green-50 px-2 py-1 text-xs font-semibold text-green-600">
                                        <span class="h-1.5 w-1.5 rounded-full bg-green-600"></span>
                                        Active
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center gap-1 rounded-full bg-red-200 px-2 py-1 text-xs font-semibold text-red-600">
                                        <span class="h-1.5 w-1.5 rounded-full bg-red-600"></span>
                                        Inactive
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="border px-4 py-2 w-40 text-center">
                                <button wire:click="edit(<?php echo e($category->id); ?>)" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1.5 px-2.5 rounded">Edit</button>
                                <button data-modal-target="delete-modal" data-modal-toggle="delete-modal" wire:click="setDeleteId(<?php echo e($category->id); ?>)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1.5 px-2.5 rounded">Delete</button>

                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="py-5 text-center">
                            No Categories Found.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



























































<div id="delete-modal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] md:h-full">
    <div class="relative w-full h-full max-w-md md:h-auto">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="delete-modal">
                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-6 text-center">
                <svg aria-hidden="true" class="mx-auto mb-4 text-gray-400 w-14 h-14 dark:text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this category?</h3>
                <button onclick="window.livewire.emit('delete')" data-modal-hide="delete-modal" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center mr-2">
                    Yes, I'm sure
                </button>
                <button data-modal-hide="delete-modal" type="button" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">No, cancel</button>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /var/www/html/resources/views/livewire/category.blade.php ENDPATH**/ ?>