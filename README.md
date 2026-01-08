# PCEP Playground (Logiscool Theme)

Kid-friendly Laravel site for practicing PCEP Python exam questions. Includes:
- Quiz view with tips and AI explanations
- Simple question editor for adding new questions
- SQLite storage with starter questions

## Quick start

```bash
php artisan migrate
php artisan db:seed
php artisan serve
```

Visit `http://127.0.0.1:8000`.

## Add new questions

Option 1: Log in at `/admin/login` and use `/questions/create`.
Option 2: Add entries to `database/seeders/QuestionSeeder.php` and re-run:

```bash
php artisan db:seed
```

## AI explanations

Set an OpenAI API key in `.env`:

```
OPENAI_API_KEY=your_key_here
OPENAI_MODEL=gpt-4o-mini
```

If the key is not set, the site falls back to the stored explanation.

## Admin login

Set an admin email and password in `.env`:

```
ADMIN_EMAIL=admin@example.com
ADMIN_PASSWORD_HASH=your_hash_here
```

Generate a bcrypt hash with:

```bash
php -r "echo password_hash('your_password', PASSWORD_BCRYPT);"
```

If you prefer, you can set `ADMIN_PASSWORD` instead of a hash (less secure).

## Bulk import for AI

On `/questions/create`, paste a JSON array into the Bulk Import box. Each item needs:
- `prompt`
- `choices` (array)
- `correct_index` (0-based)

Optional: `topic`, `difficulty`, `explanation`, `tip`.
Also supported: `code_snippet`, `image_url`.

## Delete questions (admin only)

- Delete a single question from the Quiz page.
- Delete all questions using the "Delete All Questions" button at the top of the Quiz page.
