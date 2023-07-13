<div class="p-4 grid grid-cols-1 md:grid-cols-12 m-2 gap-2 rounded-xl">
    <div class="flex items-center justify-center col-span-1 md:col-span-4 gap-2">
        {{ $menu }}
    </div>
    <div class="col-span-1 md:col-span-8 grid grid-cols-1 md:grid-cols-12 gap-2 ">
        <div class="col-span-1 md:col-span-12 text-center bg-gray-200 dark:bg-gray-800 rounded-xl">
            {{ $title }}
        </div>
        {{ $body }}
    </div>
</div>
