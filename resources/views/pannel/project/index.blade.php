@extends('layouts.pannel.app')

@section('title', 'Projects')

@section('content')
    <div class="container mx-auto px-4 snap-center text-gray-900">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold">All Our Projects are Here..</h1>
            <p class="text-lg">I Feel you have new one?! say YES..</p>
        </div>
        <div class="grid grid-cols-[repeat(auto-fill,minmax(250px,1fr))] justify-center gap-4">
            @foreach ($projects as $project)
                <x-project-card :project="$project" />
            @endforeach
        </div>

        @if ($projects->count() == 0)
            <p class="text-center italic  ">No project</p>
        @endif
    </div>
@endsection
