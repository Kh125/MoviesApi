<div class="relative" 
    x-data="{ isOpen:true }" 
    @click.away="isOpen=false"             
>
    <input wire:model.debounce.500ms="search" type="text" class="bg-gray-800 rounded-full w-64 px-4 pl-8 py-1 focus:outline-none focus:shadow-outline" placeholder="Search" 
    x-ref="search"
    @keydown.window="
        if(event.keyCode == 191){
            event.preventDefault();
            $refs.search.focus();
        }
    "
    @focus="isOpen=true"
    @keydown="isOpen=true"
    @keydown.escape.window="isOpen=false"
    >
    <div class="absolute top-0">
        <svg class="fill-current w-4 text-gray-500 mt-2 ml-2" viewBox="0 0 24 24"><path class="heroicon-ui" d="M16.32 14.9l5.39 5.4a1 1 0 01-1.42 1.4l-5.38-5.38a8 8 0 111.41-1.41zM10 16a6 6 0 100-12 6 6 0 000 12z"/></svg>
    </div>

    <div wire:loading class="spinner top-0 right-0 mt-4 mr-4"></div>

    <?php if(strlen($search) > 1): ?>
    <div class="z-50 absolute bg-gray-800 text-sm rounded w-64 mt-4" 
    x-show.transition.opacity="isOpen"

    >
        <?php if(count($searchResult) > 0): ?>
        <ul class="">
            <?php $__currentLoopData = $searchResult; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="border-b border-gray-700">
                    <a href="<?php echo e(route('movies.show', $result['id'])); ?>" class="block hover:bg-gray-700 px-3 py-3 flex items-center">
                        <?php if($result['poster_path']): ?>
                            <img src="https://image.tmdb.org/t/p/w92/<?php echo e($result['poster_path']); ?>" alt="" class="w-4">
                        <?php else: ?>
                        <img src="https://via.placeholder.com/50x75" alt="" class="w-4">
                        <?php endif; ?>                        
                        <span class="ml-4"><?php echo e($result['title']); ?></span>
                    </a>
                </li>                
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>        
        <?php else: ?>
            <div class="px-3 py-3">
                No result for "<?php echo e($search); ?>"
            </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div><?php /**PATH E:\laravelProjects\movies\resources\views/livewire/search-dropdown.blade.php ENDPATH**/ ?>