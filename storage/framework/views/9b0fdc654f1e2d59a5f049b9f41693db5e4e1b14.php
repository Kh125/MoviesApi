<div class="actor mt-8">
    <a href="<?php echo e(route('actors.show', $actor['id'])); ?>">
        <img src="<?php echo e($actor['profile_path']); ?>" alt=""
        class="hover:opacity-75 transition ease-in-out duration-150 w-72"
        >
    </a>
    <div class="mt-2">
        <a href="<?php echo e(route('actors.show', $actor['id'])); ?>" class="text-lg hover:text-gray-300">
            <?php echo e($actor['name']); ?>

        </a>
        <div class="text-sm truncate text-gray-400">
            <?php echo e($actor['known_for']); ?>

        </div>
    </div>     
</div> <?php /**PATH E:\Projects\Laravel\movies\resources\views/components/actor-card.blade.php ENDPATH**/ ?>