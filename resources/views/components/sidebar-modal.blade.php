@props(['id' => ''])
<div id="{{ $id }}"
    class="fixed top-0 left-0 z-[51] w-full md:w-1/2 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-white dark:bg-gray-800"
    tabindex="-1" aria-labelledby="{{ $id }}-label">
    <h5 id="{{ $id }}-label" class="text-base font-semibold text-gray-500 uppercase dark:text-gray-400 py-2">
        Info: <span class="title-project"></span>
    </h5>
    <button type="button" data-drawer-hide="{{ $id }}" aria-controls="{{ $id }}"
        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 end-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"></path>
        </svg>
        <span class="sr-only">Close menu</span>
    </button>
    <hr>
    <div class="py-4 overflow-y-auto content">


    </div>
</div>
