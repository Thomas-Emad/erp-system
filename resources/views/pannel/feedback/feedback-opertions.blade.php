@extends('layouts.pannel.app')

@section('title', 'Project')

@section('content')
    <div class="container mx-auto p-2 text-gray-900 ">
        <div class="bg-white rounded-xl p-4">
            <h1 class="font-bold text-xl">new Feedback:</h1>
            <hr class="my-2">

            <form action="{{ route('dashboard.feedbacks.store') }} " method="POST" enctype="multipart/form-data">
                @csrf


                <div class="mb-2">
                    <label for="name" class="block text-sm font-medium text-gray-900">
                        * Name This One
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                        placeholder="What's name This One?.." />
                </div>
                <x-error-message name="name" />

                <div class="mb-2">
                    <label for="email" class="block text-sm font-medium text-gray-900">
                        Email
                    </label>
                    <input type="text" id="email" name="email" value="{{ old('email') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                        placeholder="What's his Email?.." />
                </div>
                <x-error-message name="email" />

                <div class="mb-2">
                    <label for="message" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">* Description
                        This Feedback</label>
                    <textarea id="message" rows="4" name="message"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Write your thoughts here...">{{ old('message') }}</textarea>
                </div>
                <x-error-message name="message" />

                <div class="flex gap-2 justify-between">
                    <div class="mb-2 w-full">
                        <label for="link" class="block text-sm font-medium text-gray-900">
                            * Link Preview
                        </label>
                        <input type="text" id="link" name="link" value="{{ old('link') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                            placeholder="https://thomas-emad.com/??" />
                    </div>
                </div>
                <x-error-message name="link" />


                <div class="platform">
                    <div class="mb-2">
                        <label for="platform" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">
                            * What's that Platform
                        </label>
                        <select id="platform" name="platform"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="" selected @selected(old('platform') == '')>Doesn't matter</option>
                            <option value="upwork" @selected(old('platform') == 'upwork')>Upwork</option>
                            <option value="freelancer" @selected(old('platform') == 'freelancer')>Freelancer</option>
                            <option value="other" @selected(old('platform') == 'other')>Other</option>
                        </select>
                    </div>
                    <x-error-message name="platform" />
                </div>

                <label for="platform" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">
                    Published At:
                </label>
                <div class="relative max-w-sm">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                        </svg>
                    </div>
                    <input id="datepicker-actions" autocomplete="off" value="{{ old('published_at') }}" datepicker
                        datepicker-buttons datepicker-autoselect-today type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="* Publish Date" name="published_at">
                </div>

                <button type="submit"
                    class="mt-4 w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
            </form>
        </div>
    </div>
@endsection
