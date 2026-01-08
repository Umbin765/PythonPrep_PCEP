@extends('layouts.app')

@section('content')
    <section class="card" style="max-width: 520px; margin: 0 auto;">
        <h2 style="font-family: 'Quicksand', sans-serif; margin-top: 0;">Admin Login</h2>
        <p>Only the admin email can add new questions.</p>

        <form method="POST" action="{{ route('admin.authenticate') }}">
            @csrf
            <label class="bubble" style="display: block; margin-bottom: 16px;">
                Admin Email
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    style="width: 100%; margin-top: 6px;"
                />
            </label>

            <label class="bubble" style="display: block; margin-bottom: 16px;">
                Password
                <input
                    type="password"
                    name="password"
                    required
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
                <button class="btn" type="submit">Log in</button>
            </div>
        </form>
    </section>
@endsection
