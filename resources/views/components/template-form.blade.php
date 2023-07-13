<div class="p-4 grid grid-cols-1 md:grid-cols-12 bg-gray-200 dark:bg-gray-800 m-2 gap-2 rounded-xl">
    <div class="flex items-center justify-center col-span-1 md:col-span-4 gap-2">
        {{ $image }}
    </div>
    <div class="col-span-1 md:col-span-8 grid grid-cols-1 md:grid-cols-12 gap-2 content-center">
        {{ $form }}
    </div>
    <div class="col-span-1 md:col-span-12 grid grid-cols-1 md:flex md:flex-row-reverse mt-2">
        {{ $buttons }}
    </div>
</div>
