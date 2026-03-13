@extends('frontend.layout')

@section('title', 'News Homepage')

@section('content')
    <h1 class="text-2xl font-semibold mb-4">News Homepage</h1>

    {{-- The JS in resources/js/app.js will fetch /api/home and render into these containers --}}
    <div id="home-hero" class="mb-6"></div>
    <div id="home-top-strips" class="mb-6"></div>
    <div id="home-sections" class="mb-6"></div>
    <div id="home-galleries" class="mb-6"></div>
    <div id="home-videos" class="mb-6"></div>
    <div id="home-ads" class="mb-6"></div>
@endsection

