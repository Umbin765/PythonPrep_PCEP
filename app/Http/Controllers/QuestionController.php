<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QuestionController extends Controller
{
    public function home()
    {
        $activeCount = Question::where('is_active', true)->count();
        $topics = Question::select('topic')->where('is_active', true)->distinct()->pluck('topic');

        return view('home', [
            'activeCount' => $activeCount,
            'topics' => $topics,
        ]);
    }

    public function quiz()
    {
        $questions = Question::where('is_active', true)->orderBy('created_at')->get();

        return view('quiz', [
            'questions' => $questions,
        ]);
    }

    public function create()
    {
        return view('questions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'topic' => ['nullable', 'string', 'max:50'],
            'difficulty' => ['nullable', 'string', 'max:30'],
            'prompt' => ['required', 'string', 'max:1000'],
            'code_snippet' => ['nullable', 'string', 'max:2000'],
            'image_url' => ['nullable', 'string', 'max:2000'],
            'choices' => ['required', 'array', 'min:2', 'max:6'],
            'choices.*' => ['nullable', 'string', 'max:200'],
            'correct_index' => ['required', 'integer', 'min:0'],
            'explanation' => ['nullable', 'string', 'max:2000'],
            'tip' => ['nullable', 'string', 'max:500'],
        ]);

        $choices = array_values(array_filter($validated['choices'], function ($choice) {
            return $choice !== null && trim($choice) !== '';
        }));

        if (count($choices) < 2) {
            return back()->withErrors(['choices' => 'Add at least two answer choices.'])->withInput();
        }

        $correctIndex = (int) $validated['correct_index'];
        if ($correctIndex < 0 || $correctIndex >= count($choices)) {
            return back()->withErrors(['correct_index' => 'Correct answer index must point to a valid choice.'])->withInput();
        }

        Question::create([
            'topic' => $validated['topic'] ?? 'basics',
            'difficulty' => $validated['difficulty'] ?? 'easy',
            'prompt' => $validated['prompt'],
            'code_snippet' => $validated['code_snippet'] ?? null,
            'image_url' => $validated['image_url'] ?? null,
            'choices' => $choices,
            'correct_index' => $correctIndex,
            'explanation' => $validated['explanation'] ?? null,
            'tip' => $validated['tip'] ?? null,
            'is_active' => true,
        ]);

        return redirect()->route('quiz')->with('status', 'Question added!');
    }

    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'payload' => ['required', 'string'],
        ]);

        $decoded = json_decode($validated['payload'], true);
        if (!is_array($decoded)) {
            return back()->withErrors(['payload' => 'Paste a valid JSON array of questions.'])->withInput();
        }

        $created = 0;
        foreach ($decoded as $index => $item) {
            if (!is_array($item)) {
                continue;
            }

            $prompt = trim((string)($item['prompt'] ?? ''));
            $choices = $item['choices'] ?? [];
            $correctIndex = (int)($item['correct_index'] ?? -1);
            $codeSnippet = $item['code_snippet'] ?? null;
            $imageUrl = $item['image_url'] ?? null;

            if ($prompt === '' || !is_array($choices)) {
                continue;
            }

            $choices = array_values(array_filter($choices, function ($choice) {
                return $choice !== null && trim((string)$choice) !== '';
            }));

            if (count($choices) < 2 || $correctIndex < 0 || $correctIndex >= count($choices)) {
                continue;
            }

            Question::create([
                'topic' => $item['topic'] ?? 'basics',
                'difficulty' => $item['difficulty'] ?? 'easy',
                'prompt' => $prompt,
                'code_snippet' => $codeSnippet,
                'image_url' => $imageUrl,
                'choices' => $choices,
                'correct_index' => $correctIndex,
                'explanation' => $item['explanation'] ?? null,
                'tip' => $item['tip'] ?? null,
                'is_active' => true,
            ]);

            $created++;
        }

        if ($created === 0) {
            return back()->withErrors(['payload' => 'No valid questions found. Check your JSON.'])->withInput();
        }

        return redirect()->route('quiz')->with('status', "Imported {$created} questions!");
    }

    public function tip(Question $question)
    {
        $tip = $question->tip ?: 'Try to read the code carefully and look for the simplest rule.';

        return response()->json([
            'tip' => $tip,
        ]);
    }

    public function aiExplain(Question $question)
    {
        $apiKey = config('services.openai.key');

        if (!$apiKey) {
            return response()->json([
                'explanation' => $question->explanation ?: 'Add an AI key to get a custom explanation.',
            ]);
        }

        $model = config('services.openai.model', 'gpt-4o-mini');
        $endpoint = config('services.openai.url', 'https://api.openai.com/v1/chat/completions');

        $prompt = "Explain this PCEP-style Python question to a kid in 3 short sentences.\n";
        $prompt .= "Question: {$question->prompt}\n";
        $prompt .= "Choices: " . implode(' | ', $question->choices) . "\n";
        $prompt .= "Correct choice index: {$question->correct_index}";

        $response = Http::withToken($apiKey)
            ->timeout(10)
            ->post($endpoint, [
                'model' => $model,
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a friendly Python tutor for kids. Be cheerful, clear, and short.',
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ],
                ],
                'temperature' => 0.3,
                'max_tokens' => 120,
            ]);

        if (!$response->successful()) {
            return response()->json([
                'explanation' => $question->explanation ?: 'AI is unavailable right now. Try again later.',
            ], 200);
        }

        $content = $response->json('choices.0.message.content');

        return response()->json([
            'explanation' => $content ?: ($question->explanation ?: 'AI did not return an explanation.'),
        ]);
    }

    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()->route('quiz')->with('status', 'Question deleted.');
    }

    public function destroyAll()
    {
        Question::truncate();

        return redirect()->route('quiz')->with('status', 'All questions deleted.');
    }
}
