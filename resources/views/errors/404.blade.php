@extends('layouts.app')

@section('title', 'Page Not Found')

@section('content')

    <div class="container  p-4">
        <div class="mx-auto p-4 w-full md:w-1/2 flex flex-col items-center gap-2 bg-white rounded-xl shadow-lg"
            style="margin-top:100px">
            <img src="{{ asset('assets/image/404.png') }}" class="w-1/2" alt="Sorry This page is not found">
            <a href="{{ route('home') }}"
                class="bg-purple-700 hover:bg-purple-800 text-white font-bold py-2 px-4 rounded-xl mt-4">Back To Home</a>
        </div>
    </div>

@endsection
