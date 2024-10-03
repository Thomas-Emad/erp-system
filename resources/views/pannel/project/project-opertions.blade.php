@extends('layouts.pannel.app')

@section('title', 'Project')

@section('content')
    <div class="container mx-auto p-2 text-gray-900 ">
        <div class="bg-white rounded-xl p-4">
            <h1 class="font-bold text-xl">Project:</h1>
            <hr class="my-2">

            <form
                action="@if (!isset($project)) {{ route('dashboard.projects.store') }} @else {{ route('dashboard.projects.update', $project->id) }} @endif"
                method="POST" enctype="multipart/form-data">
                @csrf
                @if (isset($project))
                    @method('PATCH')
                @endif
                <label class="font-bold">* Upload Mockup Project:</label>
                <div class="flex items-center justify-center w-full mt-2">
                    <label for="dropzone-file"
                        class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50  hover:bg-gray-100 ">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to
                                    upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
                        </div>
                        <input id="dropzone-file" type="file" class="hidden" name="mockup" accept="image/*" />
                    </label>
                </div>
                <x-error-message name="mockup" />

                <hr class="my-2">

                <div class="mb-2">
                    <label for="title" class="block text-sm font-medium text-gray-900">
                        * Name This Project
                    </label>
                    <input type="text" id="title" name="title"
                        value="{{ old('title', isset($project) ? $project->title : '') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                        placeholder="What's name this project?.." />
                </div>
                <x-error-message name="title" />

                <div class="mb-2">
                    <label for="message" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">* Description
                        Project</label>
                    <textarea id="message" rows="4" name="description"
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Write your thoughts here...">{{ old('description', isset($project) ? $project->description : '') }}</textarea>
                </div>
                <x-error-message name="description" />

                <div class="flex gap-2 justify-between">
                    <div class="mb-2 w-full">
                        <label for="preview" class="block text-sm font-medium text-gray-900">
                            Link Preview
                        </label>
                        <input type="text" id="preview" name="preview"
                            value="{{ old('preview', isset($project) ? $project->preview : '') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                            placeholder="https://thomas-emad.com/??" />
                    </div>
                    <div class="mb-2 w-full">
                        <label for="github" class="block text-sm font-medium text-gray-900">
                            Github Link
                        </label>
                        <input type="text" id="github" name="github"
                            value="{{ old('github', isset($project) ? $project->github : '') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                            placeholder="https://github.com/Thomas-Emad/??" />
                    </div>
                </div>

                <div class="mb-2">
                    <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        * Type This Project
                    </label>
                    <select id="type" name="type"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="" selected @selected(old('type', isset($project) ? $project->type : '') == '')>Choose a tyoe</option>
                        <option value="personal" @selected(old('type', isset($project) ? $project->type : '') == 'personal')>personal</option>
                        <option value="professional" @selected(old('type', isset($project) ? $project->type : '') == 'professional')>professional</option>
                    </select>
                </div>
                <x-error-message name="type" />

                <div class="platform">
                    <div class="mb-2">
                        <label for="platform" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">
                            What's that Platform
                        </label>
                        <select id="platform" name="platform"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="" selected @selected(old('platform', isset($project) ? $project->platform : '') == '')>Doesn't matter</option>
                            <option value="upwork" @selected(old('platform', isset($project) ? $project->platform : '') == 'upwork')>Upwork</option>
                            <option value="freelancer" @selected(old('platform', isset($project) ? $project->platform : '') == 'freelancer')>Freelancer</option>
                            <option value="other" @selected(old('platform', isset($project) ? $project->platform : '') == 'other')>Other</option>
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
                    <input id="datepicker-actions" autocomplete="off"
                        value="{{ old('published_at', isset($project) ? $project->published_at : '') }}" datepicker
                        datepicker-buttons datepicker-autoselect-today type="text"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="* Publish Date" name="published_at">
                </div>

                <div class="mt-2">
                    <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white"
                        for="multiple_files">Upload
                        * multiple files</label>
                    <input
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                        id="multiple_files" name="attachments[]" type="file" accept="image/*" multiple>
                </div>
                <x-error-message name="attachments" />


                <h3 class="mb-2 mt-2 text-lg font-medium text-gray-900 dark:text-white">Choose technology:</h3>
                <ul class="flex gap-2 flex-row flex-wrap">
                    @foreach ($skills as $skill)
                        <li>
                            <input type="checkbox" id="{{ $skill->id }}-option" value="{{ $skill->id }}"
                                name="skills[]" class="hidden peer" @checked(in_array($skill->id, old('skills', isset($project) ? $project->skills->pluck('id')->toArray() : [])))>
                            <label for="{{ $skill->id }}-option"
                                class="inline-flex items-center justify-between  p-2 text-gray-500 bg-white border-2 border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 peer-checked:border-blue-600 hover:text-gray-600 dark:peer-checked:text-gray-300 peer-checked:text-gray-600 hover:bg-gray-50 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">
                                <div class="flex gap-2 items-center">
                                    <img src="{{ asset("assets/image/icons/$skill->img") }}"
                                        alt="icon {{ $skill->name }}" class='w-4 h-4'>
                                    <div class="text-sm font-semibold">{{ $skill->name }}</div>
                                </div>
                            </label>
                        </li>
                    @endforeach

                </ul>


                <button type="submit"
                    class="mt-4 w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        window.addEventListener("load", function() {
            if ({{ isset($project) && $project->type == 'personal' ? 'true' : 'false' }}) {
                document.querySelector(".platform").style.display = "none";
            }

            // change Visibility for platform
            let type = document.querySelector("select[name=type]");
            let platform = document.querySelector(".platform");
            type.addEventListener("change", function() {
                if (type.value == "personal") {
                    platform.style.display = "none";
                } else {
                    platform.style.display = "block";
                }

            })
        })
    </script>
@endsection
