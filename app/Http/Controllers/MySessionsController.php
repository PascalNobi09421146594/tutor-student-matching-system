<?php

namespace App\Http\Controllers;

use App\Models\TutoringSession;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Notifications\SessionStatusNotification;

class MySessionsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        abort_unless(
            in_array($user->role, ['student', 'tutor'], true),
            403
        );

        $participantColumn = $user->role === 'student'
            ? 'student_id'
            : 'tutor_id';

        $baseQuery = TutoringSession::where(
            $participantColumn,
            $user->id
        );

        $sessions = (clone $baseQuery)
            ->with(['student', 'tutor'])
            ->orderByDesc('scheduled_at')
            ->paginate(10);

        $upcomingCount = (clone $baseQuery)
            ->where('scheduled_at', '>=', now())
            ->whereIn('status', ['pending', 'confirmed'])
            ->count();

        $completedCount = (clone $baseQuery)
            ->where('status', 'completed')
            ->count();

        $pendingCount = (clone $baseQuery)
            ->where('status', 'pending')
            ->count();

        return view('sessions.index', compact(
            'sessions',
            'upcomingCount',
            'completedCount',
            'pendingCount'
        ));
    }

    public function create(Request $request)
    {
        abort_unless(Auth::user()->role === 'student', 403);

        $tutors = User::where('role', 'tutor')
            ->orderBy('name')
            ->get(['id', 'name']);

        $requestedTutorId = (int) $request->query('tutor_id', 0);

        $selectedTutorId = $tutors->contains(
            'id',
            $requestedTutorId
        ) ? $requestedTutorId : null;

        return view('sessions.create', compact(
            'tutors',
            'selectedTutorId'
        ));
    }

    public function store(Request $request)
    {
        abort_unless(Auth::user()->role === 'student', 403);

        $validated = $request->validate([
            'tutor_id' => [
                'required',
                'integer',
                Rule::exists('users', 'id')
                    ->where('role', 'tutor'),
            ],
            'subject' => ['required', 'string', 'max:255'],
            'scheduled_at' => ['required', 'date', 'after:now'],
            'duration_minutes' => [
                'required',
                'integer',
                Rule::in([30, 60, 90, 120]),
            ],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        $studentId = (int) Auth::id();
        $tutorId = (int) $validated['tutor_id'];

        $start = Carbon::parse($validated['scheduled_at']);
        $duration = (int) $validated['duration_minutes'];
        $end = $start->copy()->addMinutes($duration);

        $conflict = $this->findScheduleConflict(
            $studentId,
            $tutorId,
            $start,
            $end
        );

        if ($conflict) {
            return back()
                ->withInput()
                ->withErrors([
                    'scheduled_at' =>
                        'This time overlaps with an existing pending ' .
                        'or confirmed session. Please choose another time.',
                ]);
        }

        DB::transaction(function () use (
            $validated,
            $studentId,
            $tutorId
        ) {
            TutoringSession::create([
                'student_id' => $studentId,
                'tutor_id' => $tutorId,
                'subject' => $validated['subject'],
                'scheduled_at' => $validated['scheduled_at'],
                'duration_minutes' => $validated['duration_minutes'],
                'notes' => $validated['notes'] ?? null,
                'status' => 'pending',
            ]);
        });

        return redirect()
            ->route('sessions.index')
            ->with(
                'success',
                'Your tutoring session request has been sent.'
            );
    }

    public function updateStatus(
        Request $request,
        TutoringSession $session
    ) {
        $user = Auth::user();

        $validated = $request->validate([
            'status' => [
                'required',
                Rule::in(['confirmed', 'completed', 'cancelled']),
            ],
        ]);

        $newStatus = $validated['status'];

        if ($user->role === 'tutor') {
            abort_unless(
                (int) $session->tutor_id === (int) $user->id,
                403
            );

            if ($session->status === 'pending') {
                abort_unless(
                    in_array(
                        $newStatus,
                        ['confirmed', 'cancelled'],
                        true
                    ),
                    422
                );
            } elseif ($session->status === 'confirmed') {
                abort_unless(
                    in_array(
                        $newStatus,
                        ['completed', 'cancelled'],
                        true
                    ),
                    422
                );
            } else {
                abort(422, 'This session can no longer be changed.');
            }
        } elseif ($user->role === 'student') {
            abort_unless(
                (int) $session->student_id === (int) $user->id,
                403
            );

            abort_unless(
                $newStatus === 'cancelled' &&
                in_array(
                    $session->status,
                    ['pending', 'confirmed'],
                    true
                ),
                422
            );
        } else {
            abort(403);
        }

        // Check again when a tutor confirms a pending request.
        if (
            $user->role === 'tutor' &&
            $newStatus === 'confirmed'
        ) {
            $start = Carbon::parse($session->scheduled_at);
            $end = $start->copy()->addMinutes(
                (int) $session->duration_minutes
            );

            $conflict = $this->findScheduleConflict(
                (int) $session->student_id,
                (int) $session->tutor_id,
                $start,
                $end,
                (int) $session->id
            );

            if ($conflict) {
                return back()->withErrors([
                    'status' =>
                        'This session conflicts with another active ' .
                        'booking. Resolve the scheduling conflict before confirming.',
                ]);
            }
        }

            $session->update([
                'status' => $newStatus,
            ]);

            if ($user->role === 'tutor') {
                $session->load('tutor');

                $student = User::find($session->student_id);

                if ($student && in_array($newStatus, ['confirmed', 'cancelled'], true)) {
                    $notificationStatus = $newStatus;

                    $student->notify(
                        new SessionStatusNotification($session, $notificationStatus)
                    );
                }
            }

        return redirect()
            ->route('sessions.index')
            ->with('success', 'Session status updated successfully.');
    }

    /**
     * Find an overlapping pending or confirmed session involving
     * the same student or tutor.
     */
    private function findScheduleConflict(
        int $studentId,
        int $tutorId,
        Carbon $start,
        Carbon $end,
        ?int $excludeSessionId = null
    ): ?TutoringSession {
        $query = TutoringSession::query()
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($query) use ($studentId, $tutorId) {
                $query->where('student_id', $studentId)
                    ->orWhere('tutor_id', $tutorId);
            })
            ->where('scheduled_at', '<', $end);

        if ($excludeSessionId !== null) {
            $query->where('id', '!=', $excludeSessionId);
        }

        $candidates = $query->get();

        foreach ($candidates as $existingSession) {
            $existingStart = Carbon::parse(
                $existingSession->scheduled_at
            );

            $existingEnd = $existingStart->copy()->addMinutes(
                (int) $existingSession->duration_minutes
            );

            // Overlap exists when the existing session ends after
            // the requested session starts.
            if ($existingEnd->gt($start)) {
                return $existingSession;
            }
        }

        return null;
    }
}
