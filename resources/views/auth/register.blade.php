
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Join PascalEDU</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;600;700;800&display=swap"
          rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>

    <nav class="navbar">
        <div class="container">
            <a href="/" class="brand">PascalEDU<span>.</span></a>
            <a href="/" class="back-link">← Back to home</a>
        </div>
    </nav>

    <main class="register-section">
        <div class="register-card">

            <div class="register-heading">
                <span class="eyebrow">YOUR LEARNING JOURNEY STARTS HERE</span>
                <h1>Join PascalEDU</h1>
             
            </div>

            @if (session('success'))
                <div class="success-message">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="error-message">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ url('/register') }}" method="POST">
                @csrf

                <label class="form-label">I want to join as a...</label>

                <div class="role-options">
                    <label class="role-option">
                        <input type="radio" name="role" value="student" required>
                        <span class="role-content">
                            <span class="role-icon">🎓</span>
                            <strong>Student</strong>
                            <small>Find tutors to achieve my goals.</small>
                        </span>
                    </label>

                    <label class="role-option">
                        <input type="radio" name="role" value="tutor" required>
                        <span class="role-content">
                            <span class="role-icon">👩‍🏫</span>
                            <strong>Tutor</strong>
                            <small>Share my expertise and teach learners.</small>
                        </span>
                    </label>
                </div>

                <label for="name" class="form-label">Full name</label>
                <input type="text" id="name" name="name"
                       class="form-control" placeholder="Enter your full name"
                       value="{{ old('name') }}" required>
                @error('name')
                    <div class="error-message">{{ $message }}</div>
                @enderror

                <label for="email" class="form-label mt-3">Email address</label>
                <input type="email" id="email" name="email"
                       class="form-control" placeholder="you@example.com"
                       value="{{ old('email') }}" required>
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror

                <label for="password" class="form-label mt-3">Password</label>
                <input type="password" id="password" name="password"
                       class="form-control" placeholder="At least 8 characters"
                       minlength="8" required>
                @error('password')
                    <div class="error-message">{{ $message }}</div>
                @enderror

                <label for="password_confirmation" class="form-label mt-3">
                    Confirm password
                </label>
                <input type="password" id="password_confirmation"
                       name="password_confirmation" class="form-control"
                       placeholder="Enter your password again" minlength="8" required>

                <button type="submit" class="register-button">
                    Create my account →
                </button>
            </form>

            <br>

            <p class="login-prompt">
                Already have an account?
                <a href="{{ url('/login') }}">Log in</a>
            </p>

        </div>
    </main>

</body>
</html>
