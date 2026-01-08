<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>PCEP Playground</title>
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;600;700&family=Quicksand:wght@600;700&display=swap"
            rel="stylesheet"
        />
        <style>
            :root {
                --ink: #1f2937;
                --accent: #16a34a;
                --accent-soft: #dcfce7;
                --highlight: #facc15;
                --bg: #f7f8fa;
                --card: #ffffff;
                --border: #e5e7eb;
                --shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
            }

            * {
                box-sizing: border-box;
            }

            body {
                margin: 0;
                font-family: "Rubik", "Trebuchet MS", sans-serif;
                color: var(--ink);
                background: var(--bg);
                min-height: 100vh;
            }

            .page {
                display: flex;
                flex-direction: column;
                min-height: 100vh;
            }

            header {
                padding: 20px 8vw 12px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                border-bottom: 1px solid var(--border);
                background: #ffffff;
            }

            .brand {
                font-family: "Quicksand", "Trebuchet MS", sans-serif;
                font-size: 22px;
                font-weight: 700;
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .brand span {
                background: var(--highlight);
                padding: 4px 12px;
                border-radius: 12px;
            }

            nav a {
                text-decoration: none;
                color: var(--ink);
                font-weight: 600;
                margin-left: 16px;
                padding: 6px 0;
            }

            nav a:hover {
                color: var(--accent);
            }

            main {
                flex: 1;
                padding: 24px 8vw 60px;
            }

            .card {
                background: var(--card);
                border-radius: 16px;
                box-shadow: var(--shadow);
                padding: 24px;
                border: 1px solid var(--border);
            }

            .pill {
                display: inline-flex;
                align-items: center;
                gap: 6px;
                background: var(--accent-soft);
                border-radius: 999px;
                padding: 6px 12px;
                font-size: 12px;
                font-weight: 600;
            }

            .btn {
                border: none;
                border-radius: 12px;
                padding: 10px 16px;
                font-weight: 600;
                cursor: pointer;
                background: var(--accent);
                color: white;
                box-shadow: 0 8px 18px rgba(22, 163, 74, 0.18);
            }

            .btn.secondary {
                background: #111827;
                box-shadow: 0 8px 18px rgba(17, 24, 39, 0.18);
            }

            .btn.ghost {
                background: transparent;
                border: 1px solid var(--accent);
                color: var(--accent);
                box-shadow: none;
            }

            .grid {
                display: grid;
                gap: 20px;
            }

            input,
            textarea {
                width: 100%;
                padding: 10px 12px;
                border-radius: 10px;
                border: 1px solid var(--border);
                font-family: inherit;
            }

            textarea {
                resize: vertical;
            }

            small {
                color: #6b7280;
            }

            footer {
                padding: 20px 8vw 32px;
                font-size: 13px;
                opacity: 0.7;
            }

            .bubble {
                background: #f9fafb;
                border-radius: 12px;
                padding: 16px;
                border: 1px solid var(--border);
            }

            .terminal {
                background: #111827;
                color: #e5e7eb;
                border-radius: 12px;
                padding: 16px;
                font-family: "Courier New", monospace;
                font-size: 14px;
                line-height: 1.4;
                border: 1px solid #1f2937;
            }

            .terminal img {
                max-width: 100%;
                border-radius: 10px;
                display: block;
            }

            @media (min-width: 900px) {
                .grid.two {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }
                .grid.three {
                    grid-template-columns: repeat(3, minmax(0, 1fr));
                }
            }
        </style>
        @stack('head')
    </head>
    <body>
        <div class="page">
            <header>
                <div class="brand">
                    <span>Logiscool</span>
                    <div>PCEP Playground</div>
                </div>
                <nav>
                    <a href="{{ route('home') }}">Home</a>
                    <a href="{{ route('quiz') }}">Quiz</a>
                    @if(session('is_admin'))
                        <a href="{{ route('questions.create') }}">Add Question</a>
                        <form method="POST" action="{{ route('admin.logout') }}" style="display: inline;">
                            @csrf
                            <button class="btn ghost" type="submit" style="margin-left: 12px;">Log out</button>
                        </form>
                    @else
                        <a href="{{ route('admin.login') }}">Admin</a>
                    @endif
                </nav>
            </header>
            <main>
                @if(session('status'))
                    <div class="bubble" style="margin-bottom: 20px;">
                        {{ session('status') }}
                    </div>
                @endif
                @yield('content')
            </main>
            <footer>
                Built for kids learning Python basics. Keep curiosity loud and keyboards happy.
            </footer>
        </div>
        @stack('scripts')
    </body>
</html>
