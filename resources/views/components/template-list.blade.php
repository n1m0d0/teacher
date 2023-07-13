<div class="p-4 grid grid-cols-1 md:grid-cols-12 gap-2">
    <div class="col-span-1 md:col-span-6 gap-2 items-center">
        {{ $search }}
    </div>
    <div class="col-span-1 md:col-span-6 grid grid-cols-1 md:flex md:flex-row-reverse mt-2">
        {{ $options }}
    </div>
    <div class="col-span-1 md:col-span-12 mt-2">
        {{ $table }}
    </div>
    <div class="col-span-1 md:col-span-12 mt-2">
        {{ $paginate }}
    </div>
</div>