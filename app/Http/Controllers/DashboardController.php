<?php

namespace App\Http\Controllers;

use App\Models\StudentProfile;
use App\Models\TutorProfile;
use App\Models\TutoringSession;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function student()
    {
        $user = Auth::user();

        $sessions = TutoringSession::with('tutor')
            ->where('student_id', $user->id);

        $upcomingCount = (clone $sessions)
            ->where('scheduled_at', '>=', now())
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();

        $pendingCount = (clone $sessions)
            ->where('status', 'pending')
            ->count();

        $completedCount = (clone $sessions)
            ->where('status', 'completed')
            ->count();

        $recentSessions = (clone $sessions)
            ->latest('scheduled_at')
            ->take(5)
            ->get();

        $profile = StudentProfile::where('user_id', $user->id)
            ->first();

        return view('student.student_dashboard', compact(
            'upcomingCount',
            'pendingCount',
            'completedCount',
            'recentSessions',
            'profile'
        ));
    }

    public function tutor()
    {
        $user = Auth::user();

        $sessions = TutoringSession::with('student')
            ->where('tutor_id', $user->id);

        $upcomingCount = (clone $sessions)
            ->where('scheduled_at', '>=', now())
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();

        $pendingCount = (clone $sessions)
            ->where('status', 'pending')
            ->count();

        $completedCount = (clone $sessions)
            ->where('status', 'completed')
            ->count();

        $recentSessions = (clone $sessions)
            ->latest('scheduled_at')
            ->take(5)
            ->get();

        $profile = TutorProfile::where('user_id', $user->id)
            ->first();

        return view('tutor.tutor_dashboard', compact(
            'upcomingCount',
            'pendingCount',
            'completedCount',
            'recentSessions',
            'profile'
        ));
    }
}
