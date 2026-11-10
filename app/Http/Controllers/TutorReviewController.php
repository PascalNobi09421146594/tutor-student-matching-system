<?php

namespace App\Http\Controllers;

use App\Models\TutorReview;
use App\Models\TutoringSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TutorReviewController extends Controller
{
    /**
     * Save a review for a completed tutoring session.
     */
    public function store(Request $request, TutoringSession $session)
    {
        $student = $request->user();

        // Only students can submit reviews.
        if (!$student || $student->role !== 'student') {
            abort(403, 'Only students can submit reviews.');
        }

        // A student can only review their own session.
        if ((int) $session->student_id !== (int) $student->id) {
            abort(403, 'You cannot review another student\'s session.');
        }

        // Only completed sessions can be reviewed.
        if ($session->status !== 'completed') {
            return back()->with(
                'error',
                'You can only review completed tutoring sessions.'
            );
        }

        // Check if this session has already been reviewed.
        if (TutorReview::where('session_id', $session->id)->exists()) {
            return back()->with(
                'error',
                'You have already reviewed this tutoring session.'
            );
        }

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'review' => ['nullable', 'string', 'max:2000'],
        ]);

        // Use a transaction and handle a duplicate-review race safely.
        try {
            DB::transaction(function () use (
                $session,
                $student,
                $validated
            ) {
                TutorReview::create([
                    'session_id' => $session->id,
                    'student_id' => $student->id,
                    'tutor_id' => $session->tutor_id,
                    'rating' => $validated['rating'],
                    'review' => $validated['review'] ?? null,
                ]);
            });
        } catch (\Illuminate\Database\QueryException $e) {
            // The unique session_id constraint prevents duplicate reviews.
            if (TutorReview::where('session_id', $session->id)->exists()) {
                return back()->with(
                    'error',
                    'You have already reviewed this tutoring session.'
                );
            }

            throw $e;
        }

        return back()->with(
            'success',
            'Thank you! Your tutor rating and review have been submitted.'
        );
    }
}
