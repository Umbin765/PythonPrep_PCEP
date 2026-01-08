@extends('layouts.app')

@section('content')
    <section class="card" style="margin-bottom: 24px;">
        <h2 style="font-family: 'Quicksand', sans-serif; margin-top: 0;">PCEP Practice Quiz</h2>
        <p>Pick an answer, check it, then explore a tip or AI explanation.</p>
        @if(session('is_admin'))
            <form method="POST" action="{{ route('questions.destroyAll') }}" style="margin-top: 12px;">
                @csrf
                @method('DELETE')
                <button class="btn secondary" type="submit" onclick="return confirm('Delete all questions?');">
                    Delete All Questions
                </button>
            </form>
        @endif
    </section>

    <div class="grid">
        @forelse($questions as $question)
            <article class="card" data-question-id="{{ $question->id }}" data-correct-index="{{ $question->correct_index }}">
                <div class="pill" style="margin-bottom: 12px;">
                    {{ ucfirst($question->topic) }} • {{ ucfirst($question->difficulty) }}
                </div>
                <h3 style="margin-top: 0;">{{ $question->prompt }}</h3>
                @if($question->image_url || $question->code_snippet)
                    <div class="terminal" style="margin-bottom: 16px;">
                        @if($question->image_url)
                            <img src="{{ $question->image_url }}" alt="Code snippet for question {{ $question->id }}" />
                        @endif
                        @if($question->code_snippet)
                            <pre style="margin: 0; white-space: pre-wrap;">{{ $question->code_snippet }}</pre>
                        @endif
                    </div>
                @endif
                <div class="grid" style="gap: 12px;">
                    @foreach($question->choices as $index => $choice)
                        <button class="choice btn ghost terminal" type="button" data-choice-index="{{ $index }}">
                            <span>{{ $choice }}</span>
                        </button>
                    @endforeach
                </div>
                <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 16px;">
                    <button class="btn check-answer" type="button">Check Answer</button>
                    <button class="btn secondary get-tip" type="button">Get a Tip</button>
                    <button class="btn ghost ai-explain" type="button">AI Explain</button>
                    @if(session('is_admin'))
                        <form method="POST" action="{{ route('questions.destroy', $question) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn secondary" type="submit" onclick="return confirm('Delete this question?');">
                                Delete
                            </button>
                        </form>
                    @endif
                </div>
                <div class="bubble" style="margin-top: 16px; display: none;"></div>
            </article>
        @empty
            <div class="card">
                <p>No questions yet. Add one to start practicing!</p>
            </div>
        @endforelse
    </div>
@endsection

@push('scripts')
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function setBubble(card, message) {
            const bubble = card.querySelector('.bubble');
            bubble.textContent = message;
            bubble.style.display = 'block';
        }

        document.querySelectorAll('[data-question-id]').forEach((card) => {
            let selectedIndex = null;

            card.querySelectorAll('.choice').forEach((button) => {
                button.addEventListener('click', () => {
                    selectedIndex = parseInt(button.dataset.choiceIndex, 10);
                    card.querySelectorAll('.choice').forEach((choice) => {
                        choice.style.background = 'transparent';
                        choice.style.color = 'var(--accent)';
                    });
                    button.style.background = 'var(--accent)';
                    button.style.color = 'white';
                });
            });

            card.querySelector('.check-answer').addEventListener('click', () => {
                const correctIndex = parseInt(card.dataset.correctIndex, 10);
                if (selectedIndex === null) {
                    setBubble(card, 'Choose an answer first!');
                    return;
                }
                if (selectedIndex === correctIndex) {
                    setBubble(card, 'Correct! Nice job.');
                } else {
                    setBubble(card, 'Not quite. Try again or ask for a tip.');
                }
            });

            card.querySelector('.get-tip').addEventListener('click', async () => {
                const response = await fetch(`/questions/${card.dataset.questionId}/tip`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                });
                const data = await response.json();
                setBubble(card, data.tip || 'No tip yet.');
            });

            card.querySelector('.ai-explain').addEventListener('click', async () => {
                setBubble(card, 'Thinking...');
                const response = await fetch(`/questions/${card.dataset.questionId}/ai-explain`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                });
                const data = await response.json();
                setBubble(card, data.explanation || 'No explanation yet.');
            });
        });
    </script>
@endpush
