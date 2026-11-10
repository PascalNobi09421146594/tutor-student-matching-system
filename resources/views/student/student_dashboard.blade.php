
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard | PascalEDU</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        :root {
            --brown: #531f09;
            --brown-light: #783817;
            --orange: #e9a66a;
            --page: #f8f5f2;
            --text: #33251f;
            --muted: #817168;
            --border: #eadfd7;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: var(--page);
            color: var(--text);
            font-family: Arial, sans-serif;
        }

        .layout { min-height: 100vh; }

        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: 245px;
            padding: 25px 17px;
            background: var(--brown);
            color: white;
            display: flex;
            flex-direction: column;
            z-index: 100;
            overflow-y: auto;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0 8px 30px;
            color: white;
            text-decoration: none;
        }

        .brand-icon {
            display: grid;
            place-items: center;
            width: 44px;
            height: 44px;
            flex-shrink: 0;
            border-radius: 12px;
            background: var(--orange);
            color: var(--brown);
            font-size: 24px;
            font-weight: bold;
        }

        .brand h2 { font-size: 21px; margin: 0; font-weight: 700; }
        .brand small { color: #e8c5ac; font-size: 11px; }

        .nav-label {
            color: #d9b9a5;
            font-size: 11px;
            letter-spacing: 1.5px;
            padding: 0 12px;
            margin: 8px 0 12px;
            text-transform: uppercase;
        }

        .side-link {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #f7eae1;
            text-decoration: none;
            padding: 13px 14px;
            border-radius: 9px;
            margin-bottom: 7px;
            font-size: 14px;
            transition: background .2s;
        }

        .side-link:hover,
        .side-link.active {
            background: var(--brown-light);
            color: white;
        }

        .side-link.active { border-left: 3px solid var(--orange); }
        .side-icon { width: 22px; text-align: center; font-size: 18px; }

        .sidebar-footer {
            margin-top: auto;
            padding: 18px 12px 0;
            border-top: 1px solid #79503d;
            color: #e8c5ac;
            font-size: 12px;
            line-height: 1.6;
        }

        .sidebar-footer strong {
            display: block;
            color: white;
            font-size: 14px;
        }

        .logout-btn {
            width: 100%;
            text-align: left;
            border: 0;
            background: transparent;
            color: #f7eae1;
            padding: 13px 14px;
            border-radius: 9px;
        }

        .logout-btn:hover { background: var(--brown-light); }

        .main { margin-left: 245px; min-width: 0; }

        .topbar {
            min-height: 72px;
            padding: 15px 32px;
            background: white;
            border-bottom: 1px solid var(--border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 15px;
        }

        .topbar-title { font-weight: 700; color: var(--brown); }
        .user-name { font-weight: 600; font-size: 14px; }
        .user-role { color: var(--muted); font-size: 12px; }

        .content {
            padding: 32px;
            max-width: 1500px;
            margin: auto;
        }

        .welcome {
            padding: 28px;
            border-radius: 15px;
            background: var(--brown);
            color: white;
            position: relative;
            overflow: hidden;
            margin-bottom: 25px;
        }

        .welcome::after {
            content: "";
            position: absolute;
            width: 180px;
            height: 180px;
            right: -40px;
            top: -65px;
            border: 28px solid rgba(233, 166, 106, .2);
            border-radius: 50%;
            pointer-events: none;
        }

        .welcome h1 {
            font-size: 27px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .welcome p { color: #f0d9c9; margin-bottom: 18px; }

        .panel {
            background: white;
            border: 1px solid var(--border);
            border-radius: 13px;
            padding: 24px;
            margin-bottom: 22px;
            box-shadow: 0 3px 12px rgba(83, 31, 9, .03);
        }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 18px;
            color: var(--brown);
        }

        .stat-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 13px;
            padding: 22px;
            height: 100%;
            transition: transform .2s, box-shadow .2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(83, 31, 9, .07);
        }

        .stat-label {
            color: var(--muted);
            font-size: 13px;
            margin-bottom: 12px;
        }

        .stat-number {
            color: var(--brown);
            font-size: 32px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .stat-link {
            color: var(--brown-light);
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
        }

        .stat-link:hover { color: var(--brown); text-decoration: underline; }

        .session-row {
            padding: 16px 0;
            border-bottom: 1px solid #f0e8e2;
        }

        .session-row:first-of-type { padding-top: 0; }
        .session-row:last-child { border-bottom: 0; padding-bottom: 0; }

        .session-subject {
            font-size: 15px;
            font-weight: 700;
            color: var(--brown);
            margin-bottom: 6px;
        }

        .session-detail {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.6;
            margin-bottom: 4px;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            background: #f0e8e2;
            color: var(--brown);
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-pending {
            background: #fff0d8;
            color: #8a5700;
        }

        .status-confirmed {
            background: #dff3e5;
            color: #216e39;
        }

        .status-completed {
            background: #e1eafe;
            color: #234b91;
        }

        .status-cancelled {
            background: #f8dfe0;
            color: #9d252d;
        }

        .empty-text {
            color: var(--muted);
            font-size: 14px;
            line-height: 1.7;
        }

        .profile-label {
            font-size: 12px;
            font-weight: 700;
            color: var(--brown);
            margin-top: 18px;
            margin-bottom: 6px;
        }

        .profile-value {
            color: var(--text);
            font-size: 14px;
            line-height: 1.7;
            white-space: pre-line;
        }

        .btn-orange {
            display: inline-block;
            background: var(--orange);
            color: var(--brown);
            font-weight: 700;
            text-decoration: none;
            padding: 11px 17px;
            border-radius: 8px;
            border: 0;
            cursor: pointer;
        }

        .btn-orange:hover {
            background: #f3bd8a;
            color: var(--brown);
        }

        .notification-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            margin-bottom: 12px;
        }

        .notification-icon {
            display: inline-grid;
            place-items: center;
            width: 38px;
            height: 38px;
            flex-shrink: 0;
            border-radius: 50%;
            background: #f8eadc;
            color: var(--brown);
            font-size: 19px;
        }

        .notification-message {
            color: var(--text);
            font-size: 14px;
            line-height: 1.6;
            margin: 5px 0;
        }

        .notification-time {
            color: var(--muted);
            font-size: 12px;
        }

        .alert { border-radius: 9px; }

        @media (max-width: 850px) {
            .sidebar { width: 210px; }
            .main { margin-left: 210px; }
            .content { padding: 22px; }
            .topbar { padding: 15px 22px; }
        }

        @media (max-width: 650px) {
            .sidebar {
                position: static;
                width: 100%;
                min-height: auto;
            }

            .brand { padding-bottom: 15px; }
            .sidebar-footer { margin-top: 15px; }
            .main { margin-left: 0; }
            .content { padding: 17px; }
            .topbar { padding: 15px 17px; }
            .welcome { padding: 22px; }
            .welcome h1 { font-size: 23px; }
            .panel { padding: 19px; }
        }
    </style>
</head>

<body>
<div class="layout">

    <aside class="sidebar">
        <a href="{{ route('student.dashboard') }}" class="brand">
            <div class="brand-icon">P</div>
            <div>
                <h2>PascalEDU</h2>
                <small>Learn · Connect · Grow</small>
            </div>
        </a>

        <div class="nav-label">Student Menu</div>

        <a href="{{ route('student.dashboard') }}" class="side-link active">
            <span class="side-icon">⌂</span> Dashboard
        </a>

        <a href="{{ route('student.profile.edit') }}" class="side-link">
            <span class="side-icon">♙</span> My Profile
        </a>

        <a href="{{ route('student.find-tutors') }}" class="side-link">
            <span class="side-icon">⌕</span> Find Tutors
        </a>

        <a href="{{ route('sessions.index') }}" class="side-link">
            <span class="side-icon">▦</span> My Sessions
        </a>

        <div class="sidebar-footer">
            <strong>{{ Auth::user()->name }}</strong>
            Student Account

            <form method="POST" action="{{ url('/logout') }}" class="mt-3">
                @csrf
                <button type="submit" class="logout-btn">↪ Log Out</button>
            </form>
        </div>
    </aside>

    <div class="main">
        <header class="topbar">
            <span class="topbar-title">Student Workspace</span>
            <div class="text-end">
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-role">Student</div>
            </div>
        </header>

        <main class="content">

            <section class="welcome">
                <h1>Welcome back, {{ Auth::user()->name }}!</h1>
                <p>Keep learning, develop your skills, and find the right tutor for your goals.</p>
                <a href="{{ route('student.find-tutors') }}" class="btn-orange">
                    Find a Tutor &rarr;
                </a>
            </section>

            {{-- Notifications --}}
            @php
                $unreadNotificationCount = Auth::user()->unreadNotifications()->count();

                $recentNotifications = Auth::user()
                    ->unreadNotifications()
                    ->latest()
                    ->take(5)
                    ->get();
            @endphp

            <section class="panel">
                <div class="notification-header">
                    <h2 class="section-title mb-0">♧ Notifications</h2>

                    @if ($unreadNotificationCount > 0)
                        <span class="status status-pending">
                            {{ $unreadNotificationCount }} unread
                        </span>
                    @endif
                </div>

                @forelse ($recentNotifications as $notification)
                    <div class="session-row">
                        <div class="d-flex align-items-start gap-3">
                            <div class="notification-icon">
                                @if (($notification->data['status'] ?? '') === 'confirmed')
                                    ✓
                                @elseif (($notification->data['status'] ?? '') === 'cancelled')
                                    !
                                @else
                                    ♧
                                @endif
                            </div>

                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                                    <div class="session-subject">
                                        {{ $notification->data['subject'] ?? 'Tutoring Session' }}
                                    </div>

                                    @if ($notification->read_at === null)
                                        <span class="status status-pending">New</span>
                                    @else
                                        <span class="status">Read</span>
                                    @endif
                                </div>

                                <p class="notification-message">
                                    {{ $notification->data['message'] ?? 'Your tutoring session has been updated.' }}
                                </p>

                                <div class="notification-time">
                                    {{ $notification->created_at->diffForHumans() }}
                                </div>

                                <a href="{{ route('sessions.index') }}" class="stat-link">
                                    View My Sessions &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="empty-text mb-0">
                        No notifications yet. The update will appear here.
                    </p>
                @endforelse

                @if ($unreadNotificationCount > 0)
                    <form method="POST"
                          action="{{ route('notifications.read-all') }}"
                          class="mt-3">
                        @csrf
                        <button type="submit" class="btn-orange">
                            Mark All as Read
                        </button>
                    </form>
                @endif
            </section>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="status">
                    {{ session('success') }}
                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="alert"
                            aria-label="Close"></button>
                </div>
            @endif

            <h2 class="section-title">Your Learning Overview</h2>

            <div class="row g-3 mb-4">
                <div class="col-12 col-md-4">
                    <div class="stat-card">
                        <div class="stat-label">Upcoming Sessions</div>
                        <div class="stat-number">{{ $upcomingCount }}</div>
                        <a href="{{ route('sessions.index') }}" class="stat-link">
                            View sessions &rarr;
                        </a>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="stat-card">
                        <div class="stat-label">Pending Requests</div>
                        <div class="stat-number">{{ $pendingCount }}</div>
                        <a href="{{ route('sessions.index') }}" class="stat-link">
                            Check requests &rarr;
                        </a>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="stat-card">
                        <div class="stat-label">Completed Sessions</div>
                        <div class="stat-number">{{ $completedCount }}</div>
                        <a href="{{ route('sessions.index') }}" class="stat-link">
                            View history &rarr;
                        </a>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12 col-lg-7">
                    <section class="panel">
                        <h2 class="section-title">Recent Sessions</h2>

                        @forelse ($recentSessions as $session)
                            <div class="session-row">
                                <div class="d-flex flex-wrap justify-content-between gap-2">
                                    <div>
                                        <div class="session-subject">
                                            {{ $session->subject }}
                                        </div>

                                        <div class="session-detail">
                                            Tutor: {{ $session->tutor?->name ?? 'Tutor unavailable' }}
                                        </div>

                                        <div class="session-detail">
                                            {{ \Illuminate\Support\Carbon::parse($session->scheduled_at)->format('d M Y, h:i A') }}
                                            · {{ $session->duration_minutes }} minutes
                                        </div>
                                    </div>

                                    <div>
                                        <span class="status status-{{ $session->status }}">
                                            {{ ucfirst($session->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="empty-text">
                                You haven't requested any tutoring sessions yet.
                            </p>

                            <a href="{{ route('student.find-tutors') }}" class="btn-orange">
                                Explore Tutors
                            </a>
                        @endforelse

                        @if ($recentSessions->count() > 0)
                            <a href="{{ route('sessions.index') }}"
                               class="stat-link d-inline-block mt-3">
                                View all sessions &rarr;
                            </a>
                        @endif
                    </section>
                </div>

                <div class="col-12 col-lg-5">
                    <section class="panel">
                        <h2 class="section-title">My Learning Goals</h2>

                        @if ($profile && $profile->learning_goals)
                            <p class="profile-value">{{ $profile->learning_goals }}</p>
                        @else
                            <p class="empty-text">
                                Add your learning goals so you can focus on what matters most.
                            </p>
                        @endif

                        <div class="profile-label">Preferred Subjects</div>
                        <p class="profile-value">
                            {{ $profile?->preferred_subjects ?: 'Not added yet' }}
                        </p>

                        <div class="profile-label">Current Skills</div>
                        <p class="profile-value">
                            {{ $profile?->skills ?: 'Not added yet' }}
                        </p>

                        <a href="{{ route('student.profile.edit') }}" class="btn-orange">
                            Update Profile
                        </a>
                    </section>
                </div>
            </div>

        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
