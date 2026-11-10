<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TutoringSession;
use App\Models\TutorReview;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // User statistics
        $totalStudents = User::where('role', 'student')->count();

        $totalTutors = User::where('role', 'tutor')->count();

        $totalUsers = User::whereIn('role', [
            'student',
            'tutor',
            'admin',
        ])->count();

        $totalAdmins = User::where('role', 'admin')->count();

        // Tutoring session statistics
        $totalSessions = TutoringSession::count();

        $pendingSessions = TutoringSession::where(
            'status',
            'pending'
        )->count();

        $confirmedSessions = TutoringSession::where(
            'status',
            'confirmed'
        )->count();

        $completedSessions = TutoringSession::where(
            'status',
            'completed'
        )->count();

        $cancelledSessions = TutoringSession::where(
            'status',
            'cancelled'
        )->count();

        // Review statistics
        $totalReviews = TutorReview::count();

        $averageRating = TutorReview::avg('rating');

        // Recent registered users
        $recentUsers = User::whereIn('role', [
            'student',
            'tutor',
            'admin',
        ])
            ->latest()
            ->take(5)
            ->get();

        // Recent tutoring sessions
        $recentSessions = TutoringSession::with([
            'student:id,name',
            'tutor:id,name',
        ])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalStudents',
            'totalTutors',
            'totalUsers',
            'totalAdmins',
            'totalSessions',
            'pendingSessions',
            'confirmedSessions',
            'completedSessions',
            'cancelledSessions',
            'totalReviews',
            'averageRating',
            'recentUsers',
            'recentSessions'
        ));
    }
}
