<div
    class="col-span-1 md:col-span-12 grid grid-cols-1 md:grid-cols-12 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    <div class="col-span-1 md:col-span-4">
        {{ $image }}
    </div>
    <div class="col-span-1 md:col-span-8 grid grid-cols-1 md:grid-cols-12 p-5">
        <h5
            class="col-span-1 md:col-span-12 mb-2 text-center text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
            {{ $title }}
        </h5>

        <p class="col-span-1 md:col-span-12 text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400 mb-2 mt-2">
            {{ $body }}
        </p>

        {{ $button }}
    </div>
</div>
