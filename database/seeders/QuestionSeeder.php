<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            [
                'topic' => 'printing',
                'difficulty' => 'easy',
                'prompt' => 'What is the correct way to display text in Python?',
                'choices' => ['echo("Hello")', 'print("Hello")', 'say("Hello")', 'printf("Hello")'],
                'correct_index' => 1,
                'explanation' => 'Python uses the print() function to show text.',
                'tip' => 'Look for the built-in function that outputs to the screen.',
            ],
            [
                'topic' => 'variables',
                'difficulty' => 'easy',
                'prompt' => 'Which line correctly creates a variable named age with value 12?',
                'choices' => ['int age = 12', 'age = 12', 'var age: 12', 'age := 12'],
                'correct_index' => 1,
                'explanation' => 'In Python, you assign with = without declaring a type.',
                'tip' => 'Python does not need a type keyword for simple assignments.',
            ],
            [
                'topic' => 'types',
                'difficulty' => 'easy',
                'prompt' => 'What is the type of value 3.14 in Python?',
                'choices' => ['int', 'float', 'str', 'bool'],
                'correct_index' => 1,
                'explanation' => 'Numbers with a decimal point are floats.',
                'tip' => 'Decimal points mean floating-point numbers.',
            ],
            [
                'topic' => 'lists',
                'difficulty' => 'easy',
                'prompt' => 'Which creates a list of three colors?',
                'choices' => ['("red", "blue", "green")', '{"red", "blue", "green"}', '["red", "blue", "green"]', '"red", "blue", "green"'],
                'correct_index' => 2,
                'explanation' => 'Lists use square brackets in Python.',
                'tip' => 'Tuples use parentheses; lists use square brackets.',
            ],
            [
                'topic' => 'loops',
                'difficulty' => 'medium',
                'prompt' => 'How many times will this loop run? for i in range(3):',
                'choices' => ['2', '3', '4', 'It never runs'],
                'correct_index' => 1,
                'explanation' => 'range(3) creates 0, 1, 2, which is 3 numbers.',
                'tip' => 'range(n) starts at 0 and stops before n.',
            ],
            [
                'topic' => 'conditionals',
                'difficulty' => 'medium',
                'prompt' => 'Which keyword starts a conditional block in Python?',
                'choices' => ['when', 'if', 'then', 'case'],
                'correct_index' => 1,
                'explanation' => 'if starts a conditional statement in Python.',
                'tip' => 'Think of the simplest word for a condition.',
            ],
        ];

        foreach ($questions as $question) {
            Question::create($question);
        }
    }
}
