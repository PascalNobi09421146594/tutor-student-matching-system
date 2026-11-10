
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tutor Dashboard | PascalEDU</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

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

        .side-link:hover, .side-link.active {
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

        .content { padding: 32px; max-width: 1500px; margin: auto; }

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
            border: 28px solid rgba(233,166,106,.2);
            border-radius: 50%;
        }

        .welcome h1 { font-size: 27px; font-weight: 700; margin-bottom: 10px; }
        .welcome p { color: #f0d9c9; margin-bottom: 18px; }

        .btn-orange {
            display: inline-block;
            background: var(--orange);
            color: var(--brown);
            font-weight: 700;
            text-decoration: none;
            padding: 11px 17px;
            border-radius: 8px;
            border: 0;
        }

        .btn-orange:hover { background: #f3bd8a; color: var(--brown); }

        .section-title {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 16px;
            color: var(--brown);
        }

        .stat-card, .panel {
            background: white;
            border: 1px solid var(--border);
            border-radius: 13px;
            height: 100%;
        }

        .stat-card { padding: 21px; }
        .stat-label { color: var(--muted); font-size: 13px; }
        .stat-number { font-size: 31px; font-weight: 700; color: var(--brown); margin: 8px 0; }
        .stat-link { color: #87431f; font-size: 13px; text-decoration: none; }
        .stat-link:hover { text-decoration: underline; }

        .panel { padding: 22px; }
        .panel + .panel { margin-top: 22px; }

        .session-row {
            padding: 15px 0;
            border-bottom: 1px solid #f0e8e2;
        }

        .session-row:last-child { border-bottom: 0; padding-bottom: 0; }
        .session-subject { font-weight: 700; color: var(--brown); }
        .session-detail { color: var(--muted); font-size: 13px; margin-top: 5px; }

        .status {
            display: inline-block;
            border-radius: 20px;
            padding: 5px 10px;
            font-size: 11px;
            font-weight: 700;
            background: #f3eadf;
            color: #69462f;
        }

        .status-pending { background: #fff0c2; color: #795500; }
        .status-confirmed { background: #d8f0df; color: #176534; }
        .status-completed { background: #dce9ff; color: #214d91; }
        .status-cancelled { background: #f8d7da; color: #842029; }

        .profile-label { color: var(--muted); font-size: 12px; margin-bottom: 4px; }
        .profile-value { margin: 8px 0 18px; line-height: 1.6; white-space: pre-line; }
        .empty-text { color: var(--muted); font-size: 14px; line-height: 1.6; }

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

        @media (max-width: 850px) {
            .sidebar { width: 210px; }
            .main { margin-left: 210px; }
            .content { padding: 22px; }
            .topbar { padding: 15px 22px; }
        }

        @media (max-width: 650px) {
            .sidebar { position: static; width: 100%; min-height: auto; }
            .brand { padding-bottom: 15px; }
            .nav-label { margin-top: 8px; }
            .sidebar-footer { margin-top: 15px; }
            .main { margin-left: 0; }
            .content { padding: 17px; }
            .topbar { padding: 15px 17px; }
            .welcome { padding: 22px; }
            .welcome h1 { font-size: 23px; }
        }
    </style>
</head>

<body>
<div class="layout">

    <aside class="sidebar">
        <a href="{{ route('tutor.dashboard') }}" class="brand">
            <div class="brand-icon">P</div>
            <div>
                <h2>PascalEDU</h2>
                <small>Learn · Connect · Grow</small>
            </div>
        </a>

        <div class="nav-label">Tutor Menu</div>

        <a href="{{ route('tutor.dashboard') }}" class="side-link active">
            <span class="side-icon">⌂</span> Dashboard
        </a>

        <a href="{{ route('tutor.profile.edit') }}" class="side-link">
            <span class="side-icon">♙</span> My Profile
        </a>

        <a href="{{ route('sessions.index') }}" class="side-link">
            <span class="side-icon">▦</span> My Sessions
        </a>

        <div class="sidebar-footer">
            <strong>{{ Auth::user()->name }}</strong>
            Tutor Account
            <form method="POST" action="{{ url('/logout') }}" class="mt-3">
                @csrf
                <button type="submit" class="logout-btn">↪ Log Out</button>
            </form>
        </div>
    </aside>

    <div class="main">
        <header class="topbar">
            <span class="topbar-title">Tutor Workspace</span>
            <div class="text-end">
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-role">Tutor</div>
            </div>
        </header>

        <main class="content">

            <section class="welcome">
                <h1>Welcome back, {{ Auth::user()->name }}!</h1>
                <p>Manage your tutoring requests, support your students, and track your teaching activity.</p>
                <a href="{{ route('sessions.index') }}" class="btn-orange">
                    Manage Sessions &rarr;
                </a>
            </section>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="status">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                            aria-label="Close"></button>
                </div>
            @endif

            <h2 class="section-title">Your Teaching Overview</h2>

            <div class="row g-3 mb-4">
                <div class="col-12 col-md-4">
                    <div class="stat-card">
                        <div class="stat-label">Upcoming Sessions</div>
                        <div class="stat-number">{{ $upcomingCount }}</div>
                        <a href="{{ route('sessions.index') }}" class="stat-link">View sessions &rarr;</a>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="stat-card">
                        <div class="stat-label">Pending Requests</div>
                        <div class="stat-number">{{ $pendingCount }}</div>
                        <a href="{{ route('sessions.index') }}" class="stat-link">Manage requests &rarr;</a>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="stat-card">
                        <div class="stat-label">Completed Sessions</div>
                        <div class="stat-number">{{ $completedCount }}</div>
                        <a href="{{ route('sessions.index') }}" class="stat-link">View history &rarr;</a>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12 col-lg-7">
                    <section class="panel">
                        <h2 class="section-title">Recent Sessions & Requests</h2>

                        @forelse ($recentSessions as $session)
                            <div class="session-row">
                                <div class="d-flex flex-wrap justify-content-between gap-2">
                                    <div>
                                        <div class="session-subject">{{ $session->subject }}</div>
                                        <div class="session-detail">
                                            Student: {{ $session->student?->name ?? 'Student unavailable' }}
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
                            <p class="empty-text">You don't have any tutoring session requests yet.</p>
                        @endforelse

                        @if ($recentSessions->count() > 0)
                            <a href="{{ route('sessions.index') }}" class="stat-link d-inline-block mt-3">
                                Manage all sessions &rarr;
                            </a>
                        @endif
                    </section>
                </div>

                <div class="col-12 col-lg-5">
                    <section class="panel">
                        <h2 class="section-title">My Tutor Profile</h2>

                        @if ($profile)
                            <div class="profile-label">Education Level</div>
                            <p class="profile-value">
                                {{ $profile->education_level ?: 'Not added yet' }}
                            </p>

                            <div class="profile-label">Specialization</div>
                            <p class="profile-value">
                                {{ $profile->specialization ?: 'Not added yet' }}
                            </p>

                            <div class="profile-label">Subjects</div>
                            <p class="profile-value">
                                {{ $profile->subjects ?: 'Not added yet' }}
                            </p>

                            <div class="profile-label">Skills</div>
                            <p class="profile-value">
                                {{ $profile->skills ?: 'Not added yet' }}
                            </p>

                            <div class="profile-label">Experience</div>
                            <p class="profile-value">
                                {{ $profile->experience !== null
                                    ? $profile->experience . ' years'
                                    : 'Not added yet' }}
                            </p>

                            <div class="profile-label">Hourly Rate</div>
                            <p class="profile-value">
                                {{ $profile->hourly_rate !== null
                                    ? number_format((float) $profile->hourly_rate, 2)
                                    : 'Not added yet' }}
                            </p>
                        @else
                            <p class="empty-text">
                                Complete your tutor profile so students can learn about your expertise.
                            </p>
                        @endif

                        <a href="{{ route('tutor.profile.edit') }}" class="btn-orange">
                            Edit Tutor Profile
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
