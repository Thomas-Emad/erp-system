@props(['feedback'])

<div class="bg-gray-50 rounded-xl shadow-lg p-4 ">
    <div class="flex justify-between items-center gap-2">
        <div class="flex gap-2 items-center">
            <img src="{{ asset('assets/image/user.png') }}" alt="icon user ignore" class="w-12 rounded-full">
            <div>
                <h5 class="font-bold text-lg">Thoams</h5>
                <span>Freelace</span>
            </div>
        </div>
        <div class="flex gap-2 items-center">
            <a href="{{ $feedback->link }}">
                <img src="{{ asset('assets/image/' . $feedback->platform . '.png') }}"
                    alt="{{ $feedback->platform }} feedback" class="w-20">
            </a>

            <a class="cursor-pointer p-2 rounded-lg hover:bg-slate-100 duration-300"
                data-modal-target="{{ 'popup-modal' . $feedback->id }}"
                data-modal-toggle="{{ 'popup-modal' . $feedback->id }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-4 text-red-500" fill="currentColor"
                    viewBox="0 0 448 512">
                    <path
                        d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0L284.2 0c12.1 0 23.2 6.8 28.6 17.7L320 32l96 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 96C14.3 96 0 81.7 0 64S14.3 32 32 32l96 0 7.2-14.3zM32 128l384 0 0 320c0 35.3-28.7 64-64 64L96 512c-35.3 0-64-28.7-64-64l0-320zm96 64c-8.8 0-16 7.2-16 16l0 224c0 8.8 7.2 16 16 16s16-7.2 16-16l0-224c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16l0 224c0 8.8 7.2 16 16 16s16-7.2 16-16l0-224c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16l0 224c0 8.8 7.2 16 16 16s16-7.2 16-16l0-224c0-8.8-7.2-16-16-16z" />
                </svg>
            </a>
        </div>
    </div>
    <hr class="my-4">
    <p class="italic font-bold break-words">
        "{{ $feedback->message }}"
    </p>
</div>

{{-- Modal popup Delete --}}
<x-modal-popup :id="'popup-modal' . $feedback->id">
    <form action="{{ route('dashboard.feedbacks.destroy', $feedback->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete
            this feedback?</h3>
        <button data-modal-hide="popup-modal" type="submit"
            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
            Yes, I'm sure
        </button>
        <button data-modal-hide="popup-modal" type="button"
            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No,
            cancel</button>
    </form>
</x-modal-popup>
