@extends('layouts.app')

@section('content')
    <section class="card">
        <h2 style="font-family: 'Quicksand', sans-serif; margin-top: 0;">Add a New Question</h2>
        <p>Keep it short, clear, and friendly for kids preparing for the PCEP exam.</p>

        <form method="POST" action="{{ route('questions.store') }}">
            @csrf
            <div class="grid two" style="margin-bottom: 16px;">
                <label class="bubble">
                    Topic
                    <input
                        type="text"
                        name="topic"
                        value="{{ old('topic', 'basics') }}"
                        style="width: 100%; margin-top: 6px;"
                    />
                </label>
                <label class="bubble">
                    Difficulty
                    <input
                        type="text"
                        name="difficulty"
                        value="{{ old('difficulty', 'easy') }}"
                        style="width: 100%; margin-top: 6px;"
                    />
                </label>
            </div>

            <label class="bubble" style="display: block; margin-bottom: 16px;">
                Question Prompt
                <textarea name="prompt" rows="3" style="width: 100%; margin-top: 6px;">{{ old('prompt') }}</textarea>
            </label>

            <label class="bubble" style="display: block; margin-bottom: 16px;">
                Code Snippet (optional)
                <textarea name="code_snippet" rows="4" style="width: 100%; margin-top: 6px;">{{ old('code_snippet') }}</textarea>
            </label>

            <label class="bubble" style="display: block; margin-bottom: 16px;">
                Code Image URL (optional)
                <input
                    type="text"
                    name="image_url"
                    value="{{ old('image_url') }}"
                    placeholder="https://..."
                    style="width: 100%; margin-top: 6px;"
                />
            </label>

            <div class="grid two" style="margin-bottom: 16px;">
                @for($i = 0; $i < 4; $i++)
                    <label class="bubble">
                        Choice {{ $i + 1 }}
                        <input
                            type="text"
                            name="choices[]"
                            value="{{ old('choices.' . $i) }}"
                            style="width: 100%; margin-top: 6px;"
                        />
                    </label>
                @endfor
            </div>

            <label class="bubble" style="display: block; margin-bottom: 16px;">
                Correct Choice Index (0-based)
                <input
                    type="number"
                    name="correct_index"
                    min="0"
                    max="5"
                    value="{{ old('correct_index', 0) }}"
                    style="width: 100%; margin-top: 6px;"
                />
                <small>Use 0 for the first choice, 1 for the second, and so on.</small>
            </label>

            <label class="bubble" style="display: block; margin-bottom: 16px;">
                Explanation (optional)
                <textarea name="explanation" rows="3" style="width: 100%; margin-top: 6px;">{{ old('explanation') }}</textarea>
            </label>

            <label class="bubble" style="display: block; margin-bottom: 16px;">
                Tip (optional)
                <input
                    type="text"
                    name="tip"
                    value="{{ old('tip') }}"
                    style="width: 100%; margin-top: 6px;"
                />
            </label>

            @if ($errors->any())
                <div class="bubble" style="border-color: #fca5a5;">
                    <strong>Fix these:</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div style="margin-top: 20px;">
                <button class="btn" type="submit">Save Question</button>
            </div>
        </form>
    </section>

    <section class="card" style="margin-top: 24px;">
        <h3 style="font-family: 'Quicksand', sans-serif; margin-top: 0;">Bulk Import (JSON)</h3>
        <p>Paste a JSON array of questions. Each item should include prompt, choices, and correct_index.</p>

        <form method="POST" action="{{ route('questions.bulk') }}">
            @csrf
            <label class="bubble" style="display: block; margin-bottom: 16px;">
                JSON Payload
                <textarea name="payload" rows="10" style="width: 100%; margin-top: 6px;">{{ old('payload') }}</textarea>
            </label>

            <div class="bubble" style="margin-bottom: 16px;">
                Example:
                <pre style="margin: 8px 0 0; white-space: pre-wrap;">[
  {
    "topic": "basics",
    "difficulty": "easy",
    "prompt": "Which keyword starts a loop in Python?",
    "code_snippet": "for i in range(3):\n    print(i)",
    "image_url": "https://example.com/snippet.png",
    "choices": ["repeat", "for", "loop", "until"],
    "correct_index": 1,
    "explanation": "for starts a loop in Python.",
    "tip": "Look for the short keyword."
  }
]</pre>
            </div>

            @if ($errors->has('payload'))
                <div class="bubble" style="border-color: #fca5a5;">
                    {{ $errors->first('payload') }}
                </div>
            @endif

            <div style="margin-top: 20px;">
                <button class="btn secondary" type="submit">Import Questions</button>
            </div>
        </form>
    </section>
@endsection
