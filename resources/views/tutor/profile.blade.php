
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Tutor Profile | PascalEDU</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/tutor-profile.css') }}">
</head>

<body>
<div class="layout">

    <!-- Tutor sidebar -->
    <aside class="sidebar">

        <a href="{{ route('tutor.dashboard') }}" class="brand">
            <div class="brand-icon">P</div>

            <div>
                <h2>PascalEDU</h2>
                <small>Learn · Connect · Grow</small>
            </div>
        </a>

        <div class="nav-label">Tutor Menu</div>

        <a href="{{ route('tutor.dashboard') }}" class="side-link">
            <span class="side-icon">⌂</span>
            Dashboard
        </a>

        <a href="{{ route('tutor.profile.edit') }}"
           class="side-link active"
           aria-current="page">
            <span class="side-icon">♙</span>
            My Profile
        </a>

        <a href="{{ route('sessions.index') }}" class="side-link">
            <span class="side-icon">▦</span>
            My Sessions
        </a>

        <div class="sidebar-footer">
            <strong>{{ auth()->user()->name }}</strong>
            Tutor Account

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
            <span class="topbar-title">Tutor Workspace</span>

            <div class="text-end">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">Tutor</div>
            </div>
        </header>

        <main class="content">

            <section class="welcome">
                <h1>My Tutor Profile</h1>
                <p>
                    Showcase your expertise, teaching experience, and subjects
                    to help students find the right tutor.
                </p>
            </section>

            <!-- Flash message -->
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

            <form action="{{ route('tutor.profile.update') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <!-- Profile photo -->
                <section class="panel">
                    <div class="panel-header">
                        <h2 class="section-title">Profile Picture</h2>
                        <p class="panel-description">
                            Add a picture so students can recognize you.
                        </p>
                    </div>

                    <div class="panel-body">
                        <div class="photo-section">

                            <div>
                                @if ($profile->profile_photo)
                                    <img
                                        id="photoPreview"
                                        src="{{ asset('storage/' . $profile->profile_photo) }}"
                                        alt="Tutor profile picture"
                                        class="photo-preview">
                                @else
                                    <div id="photoPlaceholder"
                                         class="photo-placeholder">
                                        {{ strtoupper(substr(auth()->user()->name ?? 'T', 0, 1)) }}
                                    </div>

                                    <img
                                        id="photoPreview"
                                        src=""
                                        alt="Tutor profile picture preview"
                                        class="photo-preview d-none">
                                @endif
                            </div>

                            <div class="photo-controls">
                                <label for="profile_photo" class="form-label">
                                    Choose a Photo
                                </label>

                                <input
                                    type="file"
                                    id="profile_photo"
                                    name="profile_photo"
                                    class="form-control"
                                    accept=".jpg,.jpeg,.png,.webp">

                                <small class="field-hint">
                                    JPG, PNG or WebP. Maximum size: 2 MB.
                                </small>

                                @error('profile_photo')
                                    <div class="field-error">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </section>

                <!-- Education and specialization -->
                <section class="panel">
                    <div class="panel-header">
                        <h2 class="section-title">Education and Specialization</h2>
                        <p class="panel-description">
                            Tell students about your educational background
                            and main area of expertise.
                        </p>
                    </div>

                    <div class="panel-body">
                        <div class="row g-3">

                            <div class="col-12 col-md-6 form-group">
                                <label for="education_level" class="form-label">
                                    Education Level
                                </label>

                                <input
                                    type="text"
                                    id="education_level"
                                    name="education_level"
                                    class="form-control"
                                    value="{{ old('education_level', $profile->education_level) }}"
                                    placeholder="e.g. Bachelor's degree">

                                @error('education_level')
                                    <div class="field-error">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 col-md-6 form-group">
                                <label for="specialization" class="form-label">
                                    Specialization
                                </label>

                                <input
                                    type="text"
                                    id="specialization"
                                    name="specialization"
                                    class="form-control"
                                    value="{{ old('specialization', $profile->specialization) }}"
                                    placeholder="e.g. Computer Science">

                                @error('specialization')
                                    <div class="field-error">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>
                    </div>
                </section>

                <!-- Teaching expertise -->
                <section class="panel">
                    <div class="panel-header">
                        <h2 class="section-title">Teaching Expertise</h2>
                        <p class="panel-description">
                            Tell students which subjects you teach and
                            what skills you can help them develop.
                        </p>
                    </div>

                    <div class="panel-body">

                        <div class="form-group">
                            <label for="subjects" class="form-label">
                                Subjects You Teach
                            </label>

                            <textarea
                                id="subjects"
                                name="subjects"
                                class="form-control"
                                rows="3"
                                placeholder="e.g. Mathematics, Programming, English">{{ old('subjects', $profile->subjects) }}</textarea>

                            <small class="field-hint">
                                Separate subjects with commas for easier matching.
                            </small>

                            @error('subjects')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <label for="skills" class="form-label">
                                Skills
                            </label>

                            <textarea
                                id="skills"
                                name="skills"
                                class="form-control"
                                rows="3"
                                placeholder="e.g. PHP, Laravel, algebra, problem-solving">{{ old('skills', $profile->skills) }}</textarea>

                            <small class="field-hint">
                                Include specific skills and topics you can teach.
                            </small>

                            @error('skills')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </section>

                <!-- Experience and biography -->
                <section class="panel">
                    <div class="panel-header">
                        <h2 class="section-title">Experience and Introduction</h2>
                        <p class="panel-description">
                            Help students understand your teaching background
                            and approach.
                        </p>
                    </div>

                    <div class="panel-body">

                        <div class="form-group">
                            <label for="experience" class="form-label">
                                Teaching Experience
                            </label>

                            <textarea
                                id="experience"
                                name="experience"
                                class="form-control"
                                rows="3"
                                placeholder="Describe your teaching experience">{{ old('experience', $profile->experience) }}</textarea>

                            @error('experience')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="bio" class="form-label">
                                About Me
                            </label>

                            <textarea
                                id="bio"
                                name="bio"
                                class="form-control"
                                rows="4"
                                placeholder="Introduce yourself to potential students">{{ old('bio', $profile->bio) }}</textarea>

                            <small class="field-hint">
                                Describe your teaching style and how you help students.
                            </small>

                            @error('bio')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-0">
                            <label for="hourly_rate" class="form-label">
                                Hourly Rate
                            </label>

                            <input
                                type="number"
                                id="hourly_rate"
                                name="hourly_rate"
                                class="form-control"
                                value="{{ old('hourly_rate', $profile->hourly_rate) }}"
                                min="0"
                                max="999999"
                                step="0.01"
                                placeholder="e.g. 25.00">

                            <small class="field-hint">
                                Enter your tutoring rate per hour.
                            </small>

                            @error('hourly_rate')
                                <div class="field-error">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </section>

                <!-- Form actions -->
                <div class="form-actions mb-4">
                    <a href="{{ route('tutor.dashboard') }}"
                       class="btn-secondary-custom">
                        Back to Dashboard
                    </a>

                    <button type="submit" class="btn-orange">
                        Save Profile
                    </button>
                </div>

            </form>

        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const photoInput = document.getElementById('profile_photo');
    const photoPreview = document.getElementById('photoPreview');
    const photoPlaceholder = document.getElementById('photoPlaceholder');

    if (!photoInput || !photoPreview) {
        return;
    }

    let previewUrl = null;

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

        const maxSize = 2 * 1024 * 1024;

        if (!allowedTypes.includes(file.type)) {
            alert('Please choose a JPG, PNG, or WebP image.');
            this.value = '';
            return;
        }

        if (file.size > maxSize) {
            alert('Your profile picture must be 2 MB or smaller.');
            this.value = '';
            return;
        }

        if (previewUrl) {
            URL.revokeObjectURL(previewUrl);
        }

        previewUrl = URL.createObjectURL(file);
        photoPreview.src = previewUrl;
        photoPreview.classList.remove('d-none');

        if (photoPlaceholder) {
            photoPlaceholder.classList.add('d-none');
        }
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
