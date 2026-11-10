@extends('layouts.app')

@section('content')
<style>
    :root {
        --pascal-brown: #5b3528;
        --pascal-orange: #d97736;
        --pascal-cream: #fbf7f2;
        --pascal-text: #342820;
        --pascal-muted: #85776e;
        --pascal-border: #eadfd5;
    }

    body {
        background: var(--pascal-cream);
    }

    .sessions-page {
        max-width: 1200px;
        margin: 0 auto;
        padding: 35px 20px 60px;
        color: var(--pascal-text);
    }

    .sessions-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        margin-bottom: 28px;
    }

    .sessions-header h1 {
        color: var(--pascal-brown);
        font-size: 30px;
        font-weight: 800;
        margin-bottom: 7px;
    }

    .sessions-header p {
        color: var(--pascal-muted);
        margin: 0;
    }

    .pascal-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        padding: 10px 16px;
        border: none;
        border-radius: 9px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .pascal-btn:hover {
        opacity: 0.88;
        transform: translateY(-1px);
    }

    .btn-primary {
        background: var(--pascal-orange);
        color: #fff;
    }

    .btn-secondary {
        background: #f1e7de;
        color: var(--pascal-brown);
    }

    .btn-success {
        background: #e0f3e7;
        color: #216b3a;
    }

    .btn-danger {
        background: #fbe6e4;
        color: #a52b27;
    }

    .btn-outline {
        background: #fff;
        border: 1px solid var(--pascal-border);
        color: var(--pascal-brown);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: #fff;
        border: 1px solid var(--pascal-border);
        border-radius: 16px;
        padding: 22px;
        box-shadow: 0 5px 18px rgba(91, 53, 40, 0.04);
    }

    .stat-label {
        color: var(--pascal-muted);
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 9px;
    }

    .stat-value {
        color: var(--pascal-brown);
        font-size: 30px;
        font-weight: 800;
        line-height: 1.2;
    }

    .sessions-panel {
        background: #fff;
        border: 1px solid var(--pascal-border);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 5px 18px rgba(91, 53, 40, 0.04);
    }

    .panel-heading {
        padding: 22px 24px;
        border-bottom: 1px solid var(--pascal-border);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .panel-heading h2 {
        font-size: 19px;
        font-weight: 800;
        color: var(--pascal-brown);
        margin: 0;
    }

    .session-card {
        padding: 24px;
        border-bottom: 1px solid var(--pascal-border);
    }

    .session-card:last-child {
        border-bottom: none;
    }

    .session-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: 14px;
        margin-bottom: 16px;
    }

    .session-subject {
        font-size: 18px;
        font-weight: 800;
        color: var(--pascal-brown);
        margin: 0 0 6px;
        overflow-wrap: anywhere;
    }

    .session-person {
        font-size: 14px;
        color: var(--pascal-muted);
        margin: 0;
    }

    .status-badge {
        display: inline-block;
        padding: 6px 11px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 800;
        text-transform: capitalize;
        white-space: nowrap;
    }

    .badge-pending {
        background: #fff0d8;
        color: #925b08;
    }

    .badge-confirmed {
        background: #dcecff;
        color: #245b9c;
    }

    .badge-completed {
        background: #dcf4e4;
        color: #216b3a;
    }

    .badge-cancelled {
        background: #fbe4e2;
        color: #a52b27;
    }

    .session-details {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
        margin-bottom: 16px;
    }

    .detail-item {
        background: #fcf9f6;
        border: 1px solid #f1e8df;
        border-radius: 10px;
        padding: 12px 14px;
        min-width: 0;
    }

    .detail-label {
        color: var(--pascal-muted);
        font-size: 12px;
        margin-bottom: 5px;
    }

    .detail-value {
        color: var(--pascal-text);
        font-size: 14px;
        font-weight: 700;
        overflow-wrap: anywhere;
    }

    .session-notes {
        background: #fcf9f6;
        border-left: 3px solid var(--pascal-orange);
        padding: 12px 14px;
        margin-bottom: 18px;
        border-radius: 5px;
        font-size: 14px;
        overflow-wrap: anywhere;
    }

    .session-notes strong {
        display: block;
        color: var(--pascal-brown);
        margin-bottom: 5px;
    }

    .session-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 9px;
    }

    .session-actions form {
        margin: 0;
    }

    .review-panel {
        background: #fcf9f6;
        border: 1px solid var(--pascal-border);
        border-radius: 12px;
        padding: 20px;
        margin-top: 22px;
    }

    .review-title {
        color: var(--pascal-brown);
        font-size: 17px;
        font-weight: 800;
        margin-bottom: 8px;
    }

    .review-help {
        color: var(--pascal-muted);
        font-size: 14px;
        margin-bottom: 16px;
    }

    .review-panel .form-label {
        color: var(--pascal-brown);
        font-size: 14px;
        font-weight: 700;
    }

    .review-panel .form-control,
    .review-panel .form-select {
        border: 1px solid var(--pascal-border);
        border-radius: 9px;
        padding: 11px 12px;
    }

    .review-panel .form-control:focus,
    .review-panel .form-select:focus {
        border-color: var(--pascal-orange);
        box-shadow: 0 0 0 3px rgba(217, 119, 54, 0.15);
    }

    .review-stars {
        color: var(--pascal-orange);
        font-size: 20px;
        letter-spacing: 2px;
    }

    .review-text {
        color: var(--pascal-text);
        font-size: 14px;
        margin-top: 10px;
        margin-bottom: 0;
        overflow-wrap: anywhere;
    }

    .review-submitted {
        color: #216b3a;
        font-size: 13px;
        font-weight: 700;
        margin-top: 12px;
    }

    .empty-state {
        text-align: center;
        padding: 55px 20px;
    }

    .empty-state h3 {
        color: var(--pascal-brown);
        font-size: 20px;
        font-weight: 800;
        margin-bottom: 9px;
    }

    .empty-state p {
        color: var(--pascal-muted);
        margin-bottom: 20px;
    }

    .pagination-wrap {
        padding: 20px 24px;
        border-top: 1px solid var(--pascal-border);
    }

    .alert-success,
    .alert-errors {
        padding: 13px 16px;
        border-radius: 10px;
        margin-bottom: 22px;
    }

    .alert-success {
        border: 1px solid #b9e5c6;
        background: #e7f7ec;
        color: #216b3a;
    }

    .alert-errors {
        border: 1px solid #f0c3c0;
        background: #fff0ef;
        color: #a52b27;
    }
 
    .star-rating {
        display: inline-flex;
        flex-direction: row-reverse;
        justify-content: flex-end;
        align-items: center;
        gap: 5px;
        margin: 5px 0 8px;
    }

    .star-rating input {
        position: absolute;
        width: 1px;
        height: 1px;
        opacity: 0;
    }

    .star-rating label {
        font-size: 42px;
        line-height: 1.2;
        color: #d9cfc6;
        cursor: pointer;
        transition: color 0.15s ease, transform 0.15s ease;
    }

    .star-rating label:hover {
        transform: scale(1.12);
    }

    /* Highlight stars when hovering or selecting */
    .star-rating label:hover,
    .star-rating label:hover ~ label,
    .star-rating input:checked ~ label {
        color: #f0a52b;
    }

    /* Keyboard accessibility */
    .star-rating input:focus-visible + label {
        outline: 2px solid #5b3528;
        outline-offset: 3px;
        border-radius: 4px;
    }

    .rating-hint {
        color: #85776e;
        font-size: 13px;
        margin-top: 3px;
    }


    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
            gap: 12px;
        }

        .sessions-header h1 {
            font-size: 25px;
        }

        .session-details {
            grid-template-columns: 1fr;
        }

        .session-card {
            padding: 18px;
        }

        .panel-heading {
            padding: 18px;
        }
    }
</style>

@php
    $currentUser = auth()->user();
    $isStudent = $currentUser->role === 'student';
    $isTutor = $currentUser->role === 'tutor';
@endphp

<div class="sessions-page">

    {{-- Page heading --}}
    <div class="sessions-header">
        <div>
            <h1>My Tutoring Sessions</h1>
            <p>
                @if($isTutor)
                    Manage student requests and keep track of your tutoring sessions.
                @else
                    View your requests and manage your learning schedule.
                @endif
            </p>
        </div>

        <div class="d-flex flex-wrap gap-2">
            <a
                href="{{ $isTutor ? route('tutor.dashboard') : route('student.dashboard') }}"
                class="pascal-btn btn-outline"
            >
                Back to Dashboard
            </a>

            @if($isStudent)
                <a href="{{ route('sessions.create') }}" class="pascal-btn btn-primary">
                    + Request a Session
                </a>
            @endif
        </div>
    </div>

    {{-- Success message --}}
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- General error message --}}
    @if(session('error'))
        <div class="alert-errors">
            {{ session('error') }}
        </div>
    @endif

    {{-- Validation errors --}}
    @if($errors->any())
        <div class="alert-errors">
            <strong>Please check the following:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Statistics --}}
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Upcoming Sessions</div>
            <div class="stat-value">{{ $upcomingCount }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Pending Requests</div>
            <div class="stat-value">{{ $pendingCount }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-label">Completed Sessions</div>
            <div class="stat-value">{{ $completedCount }}</div>
        </div>
    </div>

    {{-- Sessions list --}}
    <div class="sessions-panel">
        <div class="panel-heading">
            <h2>
                @if($isTutor)
                    Student Requests & Sessions
                @else
                    Your Session History
                @endif
            </h2>

            <span style="color: var(--pascal-muted); font-size: 13px;">
                {{ $sessions->total() }} total
            </span>
        </div>

        @forelse($sessions as $session)
            @php
                $status = strtolower($session->status ?? 'pending');

                $statusClass = [
                    'pending' => 'badge-pending',
                    'confirmed' => 'badge-confirmed',
                    'completed' => 'badge-completed',
                    'cancelled' => 'badge-cancelled',
                ][$status] ?? 'badge-pending';
            @endphp

            <div class="session-card">

                {{-- Session heading --}}
                <div class="session-top">
                    <div>
                        <h3 class="session-subject">
                            {{ $session->subject }}
                        </h3>

                        <p class="session-person">
                            @if($isTutor)
                                Student:
                                {{ $session->student->name ?? 'Student account unavailable' }}
                            @else
                                Tutor:
                                {{ $session->tutor->name ?? 'Tutor account unavailable' }}
                            @endif
                        </p>
                    </div>

                    <span class="status-badge {{ $statusClass }}">
                        {{ ucfirst($status) }}
                    </span>
                </div>

                {{-- Session details --}}
                <div class="session-details">
                    <div class="detail-item">
                        <div class="detail-label">Date and Time</div>
                        <div class="detail-value">
                            @if($session->scheduled_at)
                                {{ \Illuminate\Support\Carbon::parse($session->scheduled_at)->format('d M Y, h:i A') }}
                            @else
                                Not scheduled
                            @endif
                        </div>
                    </div>

                    <div class="detail-item">
                        <div class="detail-label">Duration</div>
                        <div class="detail-value">
                            {{ $session->duration_minutes }} minutes
                        </div>
                    </div>
                </div>

                {{-- Session notes --}}
                @if($session->notes)
                    <div class="session-notes">
                        <strong>Notes from student</strong>
                        {{ $session->notes }}
                    </div>
                @endif

                {{-- Session management buttons --}}
                <div class="session-actions">

                    @if($isTutor && $status === 'pending')
                        <form
                            action="{{ route('sessions.update-status', $session) }}"
                            method="POST"
                        >
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="confirmed">

                            <button type="submit" class="pascal-btn btn-success">
                                Confirm Request
                            </button>
                        </form>

                        <form
                            action="{{ route('sessions.update-status', $session) }}"
                            method="POST"
                            onsubmit="return confirm('Are you sure you want to decline this request?');"
                        >
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="cancelled">

                            <button type="submit" class="pascal-btn btn-danger">
                                Decline Request
                            </button>
                        </form>

                    @elseif($isTutor && $status === 'confirmed')
                        <form
                            action="{{ route('sessions.update-status', $session) }}"
                            method="POST"
                            onsubmit="return confirm('Mark this session as completed?');"
                        >
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="completed">

                            <button type="submit" class="pascal-btn btn-success">
                                Mark as Completed
                            </button>
                        </form>

                        <form
                            action="{{ route('sessions.update-status', $session) }}"
                            method="POST"
                            onsubmit="return confirm('Are you sure you want to cancel this session?');"
                        >
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="cancelled">

                            <button type="submit" class="pascal-btn btn-danger">
                                Cancel Session
                            </button>
                        </form>

                    @elseif($isStudent && in_array($status, ['pending', 'confirmed'], true))
                        <form
                            action="{{ route('sessions.update-status', $session) }}"
                            method="POST"
                            onsubmit="return confirm('Are you sure you want to cancel this session?');"
                        >
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="cancelled">

                            <button type="submit" class="pascal-btn btn-danger">
                                Cancel Session
                            </button>
                        </form>

                    @else
                        <span style="color: var(--pascal-muted); font-size: 13px;">
                            No actions available for this session.
                        </span>
                    @endif

                </div>

               
                
                {{-- Student rating and review --}}
                @if($isStudent && $status === 'completed')
                    <div class="review-panel">

                        @if($session->review)
                            {{-- Show the review that has already been submitted --}}
                            <h4 class="review-title">⭐ Your Review</h4>

                            <div class="review-stars">
                                @for($i = 1; $i <= 5; $i++)
                                    {{ $i <= $session->review->rating ? '★' : '☆' }}
                                @endfor
                            </div>

                            <p>
                                <strong>{{ $session->review->rating }}/5</strong>
                            </p>

                            @if($session->review->review)
                                <p class="review-text">
                                    {{ $session->review->review }}
                                </p>
                            @endif

                        @else
                            
                            <h4 class="review-title">⭐ Rate Your Tutor</h4>

                           

                            <form
                                method="POST"
                                action="{{ route('sessions.reviews.store', $session) }}"
                            >
                                @csrf

                                <div class="mb-3">
                                    <label class="form-label">
                                        Your Rating
                                    </label>

                                    <div
                                        class="star-rating"
                                        role="radiogroup"
                                        aria-label="Choose a rating from 1 to 5 stars"
                                    >
                                        @for($i = 5; $i >= 1; $i--)
                                            <input
                                                type="radio"
                                                id="rating-{{ $session->id }}-{{ $i }}"
                                                name="rating"
                                                value="{{ $i }}"
                                                {{ old('rating') == $i ? 'checked' : '' }}
                                                required
                                            >

                                            <label
                                                for="rating-{{ $session->id }}-{{ $i }}"
                                                title="{{ $i }} star{{ $i > 1 ? 's' : '' }}"
                                                aria-label="{{ $i }} out of 5 stars"
                                            >★</label>
                                        @endfor
                                    </div>

                                    
                                </div>

                               

                                <button type="submit" class="pascal-btn btn-primary">
                                    Submit Review
                                </button>
                            </form>
                        @endif

                    </div>
                @endif


            </div>

        @empty
            <div class="empty-state">
                <h3>
                    @if($isTutor)
                        No student requests yet
                    @else
                        No tutoring sessions yet
                    @endif
                </h3>

                <p>
                    @if($isTutor)
                        When a student requests a session with you, it will appear here.
                    @else
                        Find a tutor and request your first tutoring session.
                    @endif
                </p>

                @if($isStudent)
                    <a href="{{ route('student.find-tutors') }}" class="pascal-btn btn-primary">
                        Find Tutors
                    </a>
                @endif
            </div>
        @endforelse

        {{-- Pagination --}}
        @if($sessions->hasPages())
            <div class="pagination-wrap">
                {{ $sessions->links() }}
            </div>
        @endif

    </div>
</div>
@endsection
