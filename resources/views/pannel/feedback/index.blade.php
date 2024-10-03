@extends('layouts.pannel.app')

@section('title', 'Feedbacks')

@section('content')
    <div class="container mx-auto px-4 snap-center text-gray-900">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold">Feedbacks..</h1>
        </div>
        <div class="grid grid-cols-[repeat(auto-fill,minmax(250px,1fr))] justify-center gap-4">
            @foreach ($feedbacks as $feedback)
                <x-feedback-card :feedback="$feedback" />
            @endforeach
        </div>
        @if ($feedbacks->count() == 0)
            <p class="text-center italic  ">No Feedback</p>
        @endif
    </div>
@endsection
