
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Request a Session | PascalEDU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <style>
        body { background: #f8f5f2; color: #33251f; }
        .navbar { background: #531f09; }
        .navbar-brand { color: #fff; }
        .form-panel {
            max-width: 720px;
            margin: 40px auto;
            padding: 28px;
            background: #fff;
            border: 1px solid #eadfd7;
            border-radius: 14px;
        }
        .btn-pascal { background: #8a3d18; color: #fff; }
        .btn-pascal:hover { background: #531f09; color: #fff; }
        .form-label { font-weight: 600; }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('student.dashboard') }}">
            PascalEDU
        </a>
        <a class="btn btn-outline-light btn-sm" href="{{ route('sessions.index') }}">
            Back to My Sessions
        </a>
    </div>
</nav>

<main class="container">
    <section class="form-panel">
        <h1 class="h3 fw-bold mb-2">Request a Tutoring Session</h1>
        <p class="text-secondary mb-4">
            Choose a registered tutor and provide your session details.
        </p>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($tutors->isEmpty())
            <div class="alert alert-info">
                There are no registered tutors available yet. Please check again later.
            </div>
        @else
            <form method="POST" action="{{ route('sessions.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="tutor_id" class="form-label">Choose Tutor</label>

                    <select name="tutor_id" id="tutor_id"
                            class="form-select" required>
                        <option value="">Select a tutor</option>

                        @foreach ($tutors as $tutor)
                            <option value="{{ $tutor->id }}"
                                {{ (string) old('tutor_id', $selectedTutorId) === (string) $tutor->id ? 'selected' : '' }}>
                                {{ $tutor->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" name="subject" id="subject"
                           class="form-control" maxlength="255"
                           value="{{ old('subject') }}"
                           placeholder="Example: Laravel, Mathematics"
                           required>
                </div>

                <div class="mb-3">
                    <label for="scheduled_at" class="form-label">Date and Time</label>
                    <input type="datetime-local" name="scheduled_at"
                           id="scheduled_at" class="form-control"
                           value="{{ old('scheduled_at') }}"
                           min="{{ now()->format('Y-m-d\TH:i') }}" required>
                </div>

                <div class="mb-3">
                    <label for="duration_minutes" class="form-label">Duration</label>
                    <select name="duration_minutes" id="duration_minutes"
                            class="form-select" required>
                        @foreach ([30, 60, 90, 120] as $minutes)
                            <option value="{{ $minutes }}"
                                {{ old('duration_minutes', 60) == $minutes ? 'selected' : '' }}>
                                {{ $minutes }} minutes
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="notes" class="form-label">
                        Learning Goals or Notes (Optional)
                    </label>
                    <textarea name="notes" id="notes" rows="4"
                              maxlength="2000" class="form-control"
                              placeholder="What would you like help with?">{{ old('notes') }}</textarea>
                </div>

                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-pascal">
                        Send Session Request
                    </button>
                    <a href="{{ route('sessions.index') }}"
                       class="btn btn-outline-secondary">
                        Cancel
                    </a>
                </div>
            </form>
        @endif
    </section>
</main>

</body>
</html>
