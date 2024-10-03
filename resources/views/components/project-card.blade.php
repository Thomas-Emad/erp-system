@props(['project'])
<div class="rounded-xl bg-white border-2 border-white shadow-lg overflow-hidden duration-300 hover:-translate-y-2">
    <a href="#" class="hover:opacity-90 duration-300">
        <img src="{{ Storage::url('projects/' . $project->attachments()->where('banner', true)->first()->attachment) ?? asset('assets/image/mockup.png') }}"
            alt="Project Card" class="w-full h-40">
    </a>
    <hr class="inline-block mx-auto w-96 bg-gray-200 ">
    <div class="flex justify-between gap-2 px-2 pb-2">
        <h4>{{ \Str::limit($project->title, 20) }}</h4>
        <button id="dropdownIcon-{{ $project->id }}" data-dropdown-toggle="dropdownDots-{{ $project->id }}"
            class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-900 bg-white rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-50"
            type="button">
            <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 4 15">
                <path
                    d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z" />
            </svg>
        </button>
        <!-- Dropdown menu -->
        <div id="dropdownDots-{{ $project->id }}"
            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-60 dark:bg-gray-700 dark:divide-gray-600">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                aria-labelledby="dropdownIcon-{{ $project->id }}">
                <li>
                    <a href="{{ route('dashboard.projects.show', $project->id) }}"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Show</a>
                </li>
                <li>
                    <a href="{{ route('dashboard.projects.edit', $project->id) }}"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</a>
                </li>
                <li>
                    <a data-modal-target="{{ 'popup-modal' . $project->id }}"
                        data-modal-toggle="{{ 'popup-modal' . $project->id }}"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Delete</a>
                </li>
            </ul>
        </div>
    </div>
</div>

{{-- Modal popup Delete --}}
<x-modal-popup :id="'popup-modal' . $project->id">
    <form action="{{ route('dashboard.projects.destroy', $project->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
        </svg>
        <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete
            this Project?</h3>
        <button data-modal-hide="popup-modal" type="submit"
            class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
            Yes, I'm sure
        </button>
        <button data-modal-hide="popup-modal" type="button"
            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No,
            cancel</button>
    </form>
</x-modal-popup>
