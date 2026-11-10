
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Find Tutors | PascalEDU</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/findTutor.css') }}">
</head>

<body>

<nav class="topbar">
    <div class="container-fluid px-4 d-flex flex-wrap align-items-center justify-content-between gap-3">

        <a class="brand" href="{{ route('student.dashboard') }}">
            PascalEDU
        </a>

        <div class="d-flex flex-wrap gap-3">
            <a class="nav-link" href="{{ route('student.dashboard') }}">
                Dashboard
            </a>

            <a class="nav-link" href="{{ route('student.profile.edit') }}">
                My Profile
            </a>

            <a class="nav-link" href="{{ route('sessions.index') }}">
                My Sessions
            </a>
        </div>
    </div>
</nav>

<main class="page-container">

    <div class="page-heading">
        <h1>Find Your Tutor</h1>
        <p>
            Discover tutors whose subjects, skills, and experience
            align with your learning goals.
        </p>
    </div>

    <!-- Intelligent Tutor Matching Form -->
    <section class="search-box">


        <form action="{{ route('student.find-tutors') }}" method="GET">

            <div class="mb-3">
                <label for="subject" class="form-label fw-bold">
                    Subject
                </label>

                <input
                    type="text"
                    id="subject"
                    name="subject"
                    class="form-control"
                    value="{{ $subject ?? '' }}"
                    placeholder="e.g. Computer Science"
                    maxlength="100"
                >
            </div>

            <div class="mb-3">
                <label for="skills" class="form-label fw-bold">
                    Skills you want to develop
                </label>

                <input
                    type="text"
                    id="skills"
                    name="skills"
                    class="form-control"
                    value="{{ $skillsInput ?? '' }}"
                    placeholder="e.g. Programming, Web Development"
                    maxlength="500"
                >

                <small class="text-secondary">
                    Separate skills with commas.
                </small>
            </div>

            <div class="mb-3">
                <label for="objective" class="form-label fw-bold">
                    Learning objective
                </label>

                <textarea
                    id="objective"
                    name="objective"
                    class="form-control"
                    rows="3"
                    maxlength="1000"
                    placeholder="e.g. I want to build my own website."
                >{{ $objective ?? '' }}</textarea>
            </div>

            <button type="submit" class="btn-pascal">
                Find Matching Tutors
            </button>

            <a
                href="{{ route('student.find-tutors') }}"
                class="btn btn-outline-secondary ms-2"
            >
                Clear
            </a>
        </form>
    </section>

    <!-- Tutor Count -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h5 section-heading mb-0">Registered Tutors</h2>

        <span class="text-secondary">
            {{ $tutors->total() }} tutor(s)
        </span>
    </div>

    <!-- Tutor Cards -->
    <div class="d-flex flex-column gap-3" id="tutorList">

        @forelse ($tutors as $tutor)

            @php
                $user = $tutor->user;

                $searchText = strtolower(implode(' ', array_filter([
                    $user?->name,
                    $tutor->specialization,
                    $tutor->subjects,
                    $tutor->skills,
                    $tutor->bio,
                    $tutor->education_level,
                ])));

                $hasSearchCriteria =
                    request()->filled('subject') ||
                    request()->filled('skills') ||
                    request()->filled('objective');

                $reasons = $tutor->match_reasons ?? [];
            @endphp

            <article
                class="tutor-card tutor-item"
                data-search="{{ $searchText }}"
            >

                <!-- Tutor Photo -->
                <div class="tutor-photo-column">

                    @if ($tutor->profile_photo)
                        <img
                            src="{{ asset('storage/' . $tutor->profile_photo) }}"
                            alt="{{ $user?->name ?? 'Tutor' }}"
                            class="tutor-photo"
                        >
                    @else
                        <div class="tutor-avatar">
                            {{ strtoupper(substr($user?->name ?? 'T', 0, 1)) }}
                        </div>
                    @endif

                </div>

                <!-- Tutor Information -->
                <div class="tutor-details">

                    <div class="tutor-header">
                        <div>
                            <h3 class="tutor-name">
                                {{ $user?->name ?? 'Tutor' }}
                            </h3>

                            <p class="tutor-specialization">
                                {{ $tutor->specialization ?: 'General Tutor' }}
                            </p>
                        </div>

                        @if ($hasSearchCriteria)
                            <span class="match-badge">
                                {{ $tutor->match_score ?? 0 }}% Match
                            </span>
                        @endif
                    </div>

                    
                    {{-- Tutor ratings and reviews --}}
                    <div class="tutor-rating mt-2">

                        @if(($tutor->reviews_count ?? 0) > 0)
                            <div class="rating-stars" aria-label="Rated {{ $tutor->average_rating }} out of 5">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="{{ $i <= round($tutor->average_rating) ? 'star-filled' : 'star-empty' }}">★</span>
                                @endfor
                            </div>

                            <div class="rating-details">
                                <strong>{{ number_format($tutor->average_rating, 1) }}/5</strong>

                                <span>
                                    ({{ $tutor->reviews_count }}
                                    {{ $tutor->reviews_count === 1 ? 'review' : 'reviews' }})
                                </span>
                            </div>
                        @else
                            <div class="rating-stars">
                                <span class="star-empty">☆☆☆☆☆</span>
                            </div>

                            <div class="rating-details no-reviews">
                                No reviews yet
                            </div>
                        @endif

                    </div>
                    <br>


                    <!-- Profile Information -->
                    <div class="tutor-info-grid">

                        @if ($tutor->education_level)
                            <div class="info-item">
                                <div class="info-label">Education</div>
                                <p class="info-value">
                                    {{ $tutor->education_level }}
                                </p>
                            </div>
                        @endif

                        <div class="info-item">
                            <div class="info-label">Subjects</div>
                            <p class="info-value">
                                {{ $tutor->subjects ?: 'Not provided yet' }}
                            </p>
                        </div>

                        <div class="info-item">
                            <div class="info-label">Skills</div>

                            @if ($tutor->skills)
                                @foreach (array_filter(preg_split('/[,;\n]+/', $tutor->skills)) as $skill)
                                    <span class="skill-tag">
                                        {{ trim($skill) }}
                                    </span>
                                @endforeach
                            @else
                                <p class="info-value">
                                    Not provided yet
                                </p>
                            @endif
                        </div>

                        @if (!is_null($tutor->experience))
                            <div class="info-item">
                                <div class="info-label">Experience</div>
                                <p class="info-value">
                                    {{ $tutor->experience }} years
                                </p>
                            </div>
                        @endif

                        @if ($tutor->bio)
                            <div class="info-item">
                                <div class="info-label">About</div>
                                <p class="info-value">
                                    {{ \Illuminate\Support\Str::limit($tutor->bio, 180) }}
                                </p>
                            </div>
                        @endif

                    </div>

                    <!-- Matching Explanation -->
                    @if ($hasSearchCriteria && !empty($reasons))
                        <div class="match-explanation">

                            <h4>Why this tutor may suit you</h4>

                            @foreach ($reasons as $reason)
                                @php
                                    $isStructuredReason = is_array($reason);

                                    $reasonTitle = $isStructuredReason
                                        ? ($reason['title'] ?? 'Match detail')
                                        : 'Match detail';

                                    $reasonDetail = $isStructuredReason
                                        ? ($reason['detail'] ?? '')
                                        : $reason;

                                    $isMatched = $isStructuredReason
                                        ? (bool) ($reason['matched'] ?? false)
                                        : true;
                                @endphp

                                <p class="match-reason">
                                    <span class="reason-title {{ $isMatched ? 'reason-positive' : 'reason-neutral' }}">
                                        {{ $reasonTitle }}:
                                    </span>

                                    {{ $reasonDetail }}
                                </p>
                            @endforeach

                            <p class="match-note">
                                Based on the information in the tutor's profile
                                and the learning needs you provided. Confirm
                                specific requirements with the tutor.
                            </p>
                        </div>
                    @endif

                    <!-- Rate and Request Session -->
                    <div class="tutor-footer">

                        <div>
                            @if (!is_null($tutor->hourly_rate))
                                <p class="hourly-rate">
                                    {{ number_format((float) $tutor->hourly_rate, 2) }}
                                    <small class="fs-6 fw-normal">per hour</small>
                                </p>
                            @else
                                <p class="text-secondary mb-0">
                                    Contact tutor for pricing
                                </p>
                            @endif
                        </div>

                        @if ($user)
                            <a
                                href="{{ route('sessions.create', ['tutor_id' => $user->id]) }}"
                                class="btn-pascal"
                            >
                                Request a Session
                            </a>
                        @endif

                    </div>

                </div>
            </article>

        @empty

            <div class="empty-state">
                <h3 class="h5 fw-bold">No tutors registered yet</h3>

                <p class="text-secondary">
                    Tutors will appear here once they register and save
                    their tutor profiles.
                </p>

                <a href="{{ route('student.dashboard') }}" class="btn-pascal">
                    Back to Dashboard
                </a>
            </div>

        @endforelse

    </div>

    <!-- No Live Search Results -->
    <div id="noSearchResults" class="empty-state mt-4" hidden>
        <h3 class="h5 fw-bold">No matching tutors found</h3>

        <p class="text-secondary mb-0">
            Try another name, subject, specialization, or skill.
        </p>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $tutors->links() }}
    </div>

</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('tutorSearch');
    const tutorItems = document.querySelectorAll('.tutor-item');
    const noResults = document.getElementById('noSearchResults');

    // The live-search field is optional.
    // Do not throw an error if it is not present on the page.
    if (!searchInput || !noResults) {
        return;
    }

    function filterTutors() {
        const searchTerm = searchInput.value.trim().toLowerCase();
        let visibleCount = 0;

        tutorItems.forEach(function (item) {
            const searchableText = (
                item.dataset.search || ''
            ).toLowerCase();

            const matches = searchableText.includes(searchTerm);

            item.hidden = !matches;

            if (matches) {
                visibleCount++;
            }
        });

        noResults.hidden = (
            visibleCount > 0 || tutorItems.length === 0
        );
    }

    searchInput.addEventListener('input', filterTutors);
});
</script>

</body>
</html>
