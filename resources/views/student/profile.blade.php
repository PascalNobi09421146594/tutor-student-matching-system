
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Profile | PascalEDU</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
        
    <link rel="stylesheet" href="{{ asset('css/student-profile.css') }}">

  
</head>

<body>
<div class="layout">

    <!-- Sidebar -->
    <aside class="sidebar">
        <a href="{{ route('student.dashboard') }}" class="brand">
            <div class="brand-icon">P</div>
            <div>
                <h2>PascalEDU</h2>
                <small>Learn · Connect · Grow</small>
            </div>
        </a>

        <div class="nav-label">Student Menu</div>

        <a href="{{ route('student.dashboard') }}" class="side-link">
            <span class="side-icon">⌂</span>
            Dashboard
        </a>

        <a href="{{ route('student.profile.edit') }}"
           class="side-link active"
           aria-current="page">
            <span class="side-icon">♙</span>
            My Profile
        </a>

        <a href="{{ route('student.find-tutors') }}" class="side-link">
            <span class="side-icon">⌕</span>
            Find Tutors
        </a>

        <a href="{{ route('sessions.index') }}" class="side-link">
            <span class="side-icon">▦</span>
            My Sessions
        </a>

        <div class="sidebar-footer">
            <strong>{{ Auth::user()->name }}</strong>
            Student Account

            <form method="POST" action="{{ url('/logout') }}" class="mt-3">
                @csrf
                <button type="submit" class="logout-btn">
                    ↪ Log Out
                </button>
            </form>
        </div>
    </aside>

    <!-- Main content -->
    <div class="main">

        <header class="topbar">
            <span class="topbar-title">Student Workspace</span>

            <div class="text-end">
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-role">Student</div>
            </div>
        </header>

        <main class="content">

            <!-- Welcome banner -->
            <section class="welcome">
                <h1>My Learning Profile</h1>
                <p>
                    Personalize your learning experience and help PascalEDU
                    match you with tutors who fit your goals.
                </p>
            </section>

            
            @if (Auth::user()->unreadNotifications->isNotEmpty())
                <section class="panel mb-4">
                    <h2 class="section-title">Notifications</h2>

                    @foreach (Auth::user()->unreadNotifications as $notification)
                        <div class="session-row">
                            <div class="session-subject">
                                {{ $notification->data['subject'] ?? 'Tutoring Session' }}
                            </div>

                            <div class="session-detail">
                                {{ $notification->data['message'] ?? 'Your session has been updated.' }}
                            </div>

                            <div class="session-detail">
                                {{ $notification->created_at->diffForHumans() }}
                            </div>

                            @if (!empty($notification->data['session_id']))
                                <a href="{{ route('sessions.index') }}"
                                class="stat-link">
                                    View sessions &rarr;
                                </a>
                            @endif
                        </div>
                    @endforeach

                    <form method="POST" action="{{ route('notifications.read-all') }}">
                        @csrf
                        <button type="submit" class="btn-orange mt-3">
                            Mark All as Read
                        </button>
                    </form>
                </section>
            @endif


            <!-- Success message -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show"
                     role="status">
                    {{ session('success') }}
                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Close"></button>
                </div>
            @endif

            <!-- Validation errors -->
            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <strong>Please correct the following:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Profile form: one form only -->
            <form action="{{ route('student.profile.update') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <section class="panel">

                    <div class="panel-header">
                        <h2 class="section-title">Profile Information</h2>
                        <p class="panel-description">
                            Keep your information up to date to improve your
                            tutor recommendations.
                        </p>
                    </div>

                    <div class="panel-body">

                        <!-- Profile photo -->
                        <div class="photo-section">
                            <div>
                                @if ($profile->profile_photo)
                                    <img
                                        src="{{ asset('storage/' . $profile->profile_photo) }}"
                                        alt="Student profile picture"
                                        id="photoPreview"
                                        class="photo-preview">
                                @else
                                    <div id="photoPlaceholder"
                                         class="photo-placeholder">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>

                                    <img
                                        src=""
                                        alt="Selected profile picture preview"
                                        id="photoPreview"
                                        class="photo-preview d-none">
                                @endif
                            </div>

                            <div class="photo-controls">
                                <label for="profile_photo" class="form-label">
                                    Profile Picture
                                </label>

                                <input
                                    type="file"
                                    name="profile_photo"
                                    id="profile_photo"
                                    class="form-control"
                                    accept=".jpg,.jpeg,.png,.webp">

                                <small class="field-hint">
                                    JPG, PNG, or WebP. Maximum size: 2 MB.
                                </small>

                                @error('profile_photo')
                                    <div class="field-error">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="education_level" class="form-label">
                                Education Level
                            </label>

                            <select name="education_level"
                                    id="education_level"
                                    class="form-select">
                                <option value="">Select your education level</option>

                                @foreach ([
                                    'Secondary School',
                                    'High School',
                                    'Diploma',
                                    'Undergraduate',
                                    'Postgraduate',
                                    'Other'
                                ] as $level)
                                    <option value="{{ $level }}"
                                        {{ old('education_level', $profile->education_level) == $level ? 'selected' : '' }}>
                                        {{ $level }}
                                    </option>
                                @endforeach
                            </select>

                            <small class="field-hint">
                                Choose your current level of education.
                            </small>

                            @error('education_level')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="skills" class="form-label">
                                Current Skills
                            </label>

                            <textarea
                                name="skills"
                                id="skills"
                                rows="3"
                                maxlength="5000"
                                class="form-control"
                                placeholder="Example: HTML, PHP basics, algebra, problem-solving">{{ old('skills', $profile->skills) }}</textarea>

                            <small class="field-hint">
                                List the skills you already have or topics you understand.
                            </small>

                            @error('skills')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="learning_goals" class="form-label">
                                Learning Goals
                            </label>

                            <textarea
                                name="learning_goals"
                                id="learning_goals"
                                rows="3"
                                maxlength="5000"
                                class="form-control"
                                placeholder="Example: I want to improve my Laravel skills and build web applications.">{{ old('learning_goals', $profile->learning_goals) }}</textarea>

                            <small class="field-hint">
                                Describe what you want to learn or improve.
                            </small>

                            @error('learning_goals')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="preferred_subjects" class="form-label">
                                Preferred Subjects
                            </label>

                            <textarea
                                name="preferred_subjects"
                                id="preferred_subjects"
                                rows="3"
                                maxlength="5000"
                                class="form-control"
                                placeholder="Example: Programming, Mathematics, Database Management">{{ old('preferred_subjects', $profile->preferred_subjects) }}</textarea>

                            <small class="field-hint">
                                List the subjects you would like help with.
                            </small>

                            @error('preferred_subjects')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Actions -->
                        <div class="form-actions">
                            <button type="submit" class="btn-orange">
                                Save Profile
                            </button>

                            <a href="{{ route('student.dashboard') }}"
                               class="btn-secondary-custom">
                                Back to Dashboard
                            </a>
                        </div>

                    </div>
                </section>
            </form>

        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const photoInput = document.getElementById('profile_photo');
    const photoPreview = document.getElementById('photoPreview');
    const photoPlaceholder = document.getElementById('photoPlaceholder');

    if (photoInput && photoPreview) {
        photoInput.addEventListener('change', function () {
            const file = this.files[0];

            if (!file) {
                return;
            }

            const allowedTypes = [
                'image/jpeg',
                'image/png',
                'image/webp'
            ];

            if (!allowedTypes.includes(file.type)) {
                alert('Please select a JPG, PNG, or WebP image.');
                this.value = '';
                return;
            }

            if (file.size > 2 * 1024 * 1024) {
                alert('Your profile picture must be 2 MB or smaller.');
                this.value = '';
                return;
            }

            if (photoPreview.dataset.previewUrl) {
                URL.revokeObjectURL(photoPreview.dataset.previewUrl);
            }

            const previewUrl = URL.createObjectURL(file);

            photoPreview.dataset.previewUrl = previewUrl;
            photoPreview.src = previewUrl;
            photoPreview.classList.remove('d-none');

            if (photoPlaceholder) {
                photoPlaceholder.classList.add('d-none');
            }
        });
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
