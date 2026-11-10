@extends('layouts.app')

@section('content')
<style>
    :root {
        --admin-brown: #5b3528;
        --admin-orange: #d97736;
        --admin-cream: #fbf7f2;
        --admin-muted: #85776e;
        --admin-border: #eadfd5;
    }

    .admin-page {
        max-width: 1250px;
        margin: 0 auto;
        padding: 35px 20px 60px;
        color: #342820;
    }

    .admin-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
        margin-bottom: 28px;
    }

    .admin-header h1 {
        color: var(--admin-brown);
        font-size: 30px;
        font-weight: 800;
        margin-bottom: 7px;
    }

    .admin-header p {
        color: var(--admin-muted);
        margin: 0;
    }

    .admin-badge {
        background: #f4e3d7;
        color: var(--admin-brown);
        padding: 9px 14px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 800;
    }

    .admin-stats {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 28px;
    }

    .admin-stat {
        background: #fff;
        border: 1px solid var(--admin-border);
        border-radius: 15px;
        padding: 22px;
        box-shadow: 0 5px 18px rgba(91, 53, 40, .04);
    }

    .admin-stat-label {
        color: var(--admin-muted);
        font-size: 13px;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .admin-stat-value {
        color: var(--admin-brown);
        font-size: 30px;
        font-weight: 800;
    }

    .admin-stat-icon {
        font-size: 23px;
        margin-bottom: 10px;
    }

    .admin-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 22px;
        margin-bottom: 24px;
    }

    .admin-panel {
        background: #fff;
        border: 1px solid var(--admin-border);
        border-radius: 15px;
        overflow: hidden;
        margin-bottom: 24px;
        box-shadow: 0 5px 18px rgba(91, 53, 40, .04);
    }

    .admin-panel-header {
        padding: 20px 22px;
        border-bottom: 1px solid var(--admin-border);
    }

    .admin-panel-header h2 {
        color: var(--admin-brown);
        font-size: 18px;
        font-weight: 800;
        margin: 0;
    }

    .admin-panel-body {
        padding: 22px;
    }

    .admin-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding: 13px 0;
        border-bottom: 1px solid #f1e8df;
    }

    .admin-row:last-child {
        border-bottom: none;
    }

    .admin-row-label {
        color: var(--admin-muted);
        font-size: 14px;
    }

    .admin-row-value {
        color: var(--admin-brown);
        font-weight: 800;
    }

    .admin-table-wrap {
        overflow-x: auto;
    }

    .admin-table {
        width: 100%;
        border-collapse: collapse;
    }

    .admin-table th {
        text-align: left;
        background: #fcf9f6;
        color: var(--admin-muted);
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: .4px;
    }

    .admin-table th,
    .admin-table td {
        padding: 14px 20px;
        border-bottom: 1px solid #f1e8df;
        white-space: nowrap;
    }

    .admin-table td {
        font-size: 13px;
    }

    .admin-table tr:last-child td {
        border-bottom: none;
    }

    .admin-status {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 800;
        text-transform: capitalize;
    }

    .status-pending {
        background: #fff0d8;
        color: #925b08;
    }

    .status-confirmed {
        background: #dcecff;
        color: #245b9c;
    }

    .status-completed {
        background: #dcf4e4;
        color: #216b3a;
    }

    .status-cancelled {
        background: #fbe4e2;
        color: #a52b27;
    }

    .admin-empty {
        padding: 25px;
        text-align: center;
        color: var(--admin-muted);
    }

    .admin-rating {
        color: #d97736;
        font-weight: 800;
    }

    @media (max-width: 900px) {
        .admin-stats {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 600px) {
        .admin-stats,
        .admin-grid {
            grid-template-columns: 1fr;
        }

        .admin-header h1 {
            font-size: 25px;
        }

        .admin-stat {
            padding: 18px;
        }
    }
</style>

<div class="admin-page">

    <div class="admin-header">
        <div>
            <h1>PascalEDU Admin Dashboard</h1>
            <p>Monitor users, tutoring sessions, and student reviews.</p>
        </div>

        <span class="admin-badge">
            🛡 Administrator
        </span>
    </div>

    {{-- Main statistics --}}
    <div class="admin-stats">

        <div class="admin-stat">
            <div class="admin-stat-icon">🎓</div>
            <div class="admin-stat-label">Total Students</div>
            <div class="admin-stat-value">{{ $totalStudents }}</div>
        </div>

        <div class="admin-stat">
            <div class="admin-stat-icon">👨‍🏫</div>
            <div class="admin-stat-label">Total Tutors</div>
            <div class="admin-stat-value">{{ $totalTutors }}</div>
        </div>

        <div class="admin-stat">
            <div class="admin-stat-icon">📚</div>
            <div class="admin-stat-label">Total Sessions</div>
            <div class="admin-stat-value">{{ $totalSessions }}</div>
        </div>

        <div class="admin-stat">
            <div class="admin-stat-icon">⭐</div>
            <div class="admin-stat-label">Total Reviews</div>
            <div class="admin-stat-value">{{ $totalReviews }}</div>
        </div>

    </div>

    {{-- Detailed statistics --}}
    <div class="admin-grid">

        <section class="admin-panel">
            <div class="admin-panel-header">
                <h2>👥 User Overview</h2>
            </div>

            <div class="admin-panel-body">
                <div class="admin-row">
                    <span class="admin-row-label">All users</span>
                    <span class="admin-row-value">{{ $totalUsers }}</span>
                </div>

                <div class="admin-row">
                    <span class="admin-row-label">Students</span>
                    <span class="admin-row-value">{{ $totalStudents }}</span>
                </div>

                <div class="admin-row">
                    <span class="admin-row-label">Tutors</span>
                    <span class="admin-row-value">{{ $totalTutors }}</span>
                </div>

                <div class="admin-row">
                    <span class="admin-row-label">Administrators</span>
                    <span class="admin-row-value">{{ $totalAdmins }}</span>
                </div>
            </div>
        </section>

        <section class="admin-panel">
            <div class="admin-panel-header">
                <h2>📅 Session Overview</h2>
            </div>

            <div class="admin-panel-body">
                <div class="admin-row">
                    <span class="admin-row-label">Pending</span>
                    <span class="admin-row-value">{{ $pendingSessions }}</span>
                </div>

                <div class="admin-row">
                    <span class="admin-row-label">Confirmed</span>
                    <span class="admin-row-value">{{ $confirmedSessions }}</span>
                </div>

                <div class="admin-row">
                    <span class="admin-row-label">Completed</span>
                    <span class="admin-row-value">{{ $completedSessions }}</span>
                </div>

                <div class="admin-row">
                    <span class="admin-row-label">Cancelled</span>
                    <span class="admin-row-value">{{ $cancelledSessions }}</span>
                </div>
            </div>
        </section>

    </div>

    {{-- Review overview --}}
    <section class="admin-panel">
        <div class="admin-panel-header">
            <h2>⭐ Tutor Review Overview</h2>
        </div>

        <div class="admin-panel-body">
            <div class="admin-row">
                <span class="admin-row-label">Total submitted reviews</span>
                <span class="admin-row-value">{{ $totalReviews }}</span>
            </div>

            <div class="admin-row">
                <span class="admin-row-label">Average platform rating</span>
                <span class="admin-row-value admin-rating">
                    @if($averageRating !== null)
                        ★ {{ number_format($averageRating, 1) }} / 5
                    @else
                        No ratings yet
                    @endif
                </span>
            </div>
        </div>
    </section>

    {{-- Recent users --}}
    <section class="admin-panel">
        <div class="admin-panel-header">
            <h2>🆕 Recently Registered Users</h2>
        </div>

        @if($recentUsers->isEmpty())
            <div class="admin-empty">
                No registered users found.
            </div>
        @else
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Registered</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($recentUsers as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="admin-status status-confirmed">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td>{{ $user->created_at->format('d M Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <a href="{{ route('admin.users') }}"
            class="btn btn-dark">
                Manage Users
        </a>
        
    </section>

    {{-- Recent sessions --}}
    <section class="admin-panel">
        <div class="admin-panel-header">
            <h2>📖 Recent Tutoring Sessions</h2>
        </div>

        @if($recentSessions->isEmpty())
            <div class="admin-empty">
                No tutoring sessions found.
            </div>
        @else
            <div class="admin-table-wrap">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Student</th>
                            <th>Tutor</th>
                            <th>Status</th>
                            <th>Scheduled</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($recentSessions as $session)
                            @php
                                $sessionStatus = strtolower($session->status ?? 'pending');

                                $sessionStatusClass = [
                                    'pending' => 'status-pending',
                                    'confirmed' => 'status-confirmed',
                                    'completed' => 'status-completed',
                                    'cancelled' => 'status-cancelled',
                                ][$sessionStatus] ?? 'status-pending';
                            @endphp

                            <tr>
                                <td>{{ $session->subject }}</td>
                                <td>{{ $session->student->name ?? 'Unavailable' }}</td>
                                <td>{{ $session->tutor->name ?? 'Unavailable' }}</td>
                                <td>
                                    <span class="admin-status {{ $sessionStatusClass }}">
                                        {{ $sessionStatus }}
                                    </span>
                                </td>
                                <td>
                                    @if($session->scheduled_at)
                                        {{ \Illuminate\Support\Carbon::parse($session->scheduled_at)->format('d M Y, h:i A') }}
                                    @else
                                        Not scheduled
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>

</div>
@endsection
