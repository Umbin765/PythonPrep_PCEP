@extends('layouts.app')

@section('content')
    <div class="grid two">
        <section class="card">
            <div class="pill">PCEP Prep Zone</div>
            <h1 style="font-family: 'Quicksand', sans-serif; font-size: 36px; margin-bottom: 12px;">
                Learn Python like a puzzle adventure.
            </h1>
            <p style="font-size: 18px; line-height: 1.5;">
                Practice PCEP-style questions, unlock hints, and get kid-friendly explanations.
                Every answer is a chance to grow your coding superpowers.
            </p>
            <div style="display: flex; gap: 12px; flex-wrap: wrap; margin-top: 20px;">
                <a class="btn" href="{{ route('quiz') }}">Start the Quiz</a>
            </div>
        </section>
        <section class="grid" style="align-content: start;">
            <div class="card">
                <h3 style="margin-top: 0;">What you will train</h3>
                <div class="grid three">
                    <div class="bubble">
                        <strong>Basics</strong>
                        <p>Print, variables, and simple math.</p>
                    </div>
                    <div class="bubble">
                        <strong>Logic</strong>
                        <p>if, elif, else, and Boolean thinking.</p>
                    </div>
                    <div class="bubble">
                        <strong>Loops</strong>
                        <p>repeat actions and spot patterns.</p>
                    </div>
                </div>
            </div>
            <div class="card">
                <h3 style="margin-top: 0;">Your quiz library</h3>
                <p style="font-size: 18px;">Active questions: <strong>{{ $activeCount }}</strong></p>
                <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                    @forelse($topics as $topic)
                        <span class="pill">{{ ucfirst($topic) }}</span>
                    @empty
                        <span class="pill">Add your first topic</span>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
@endsection
