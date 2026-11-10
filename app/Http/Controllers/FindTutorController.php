<?php

namespace App\Http\Controllers;

use App\Models\TutorProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;

class FindTutorController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'subject' => ['nullable', 'string', 'max:100'],
            'skills' => ['nullable', 'string', 'max:500'],
            'objective' => ['nullable', 'string', 'max:1000'],
        ]);

        $subject = trim($validated['subject'] ?? '');
        $skillsInput = trim($validated['skills'] ?? '');
        $objective = trim($validated['objective'] ?? '');

        $requestedSkills = $this->extractTerms($skillsInput);
        $objectiveTerms = $this->extractTerms($objective);

        // Retrieve tutor profiles, user accounts and review statistics.
        $tutors = TutorProfile::with([
                'user' => function ($query) {
                    $query->where('role', 'tutor')
                        ->withAvg('tutorReviews', 'rating')
                        ->withCount('tutorReviews');
                },
            ])
            ->whereHas('user', function ($query) {
                $query->where('role', 'tutor');
            })
            ->get()
            ->filter(function ($profile) {
                return $profile->user !== null;
            })
            ->map(function ($profile) use (
                $subject,
                $requestedSkills,
                $objectiveTerms
            ) {
                $user = $profile->user;

                // Make rating information available directly on the profile.
                $profile->average_rating = $user->tutor_reviews_avg_rating !== null
                    ? round((float) $user->tutor_reviews_avg_rating, 1)
                    : null;

                $profile->reviews_count = (int) $user->tutor_reviews_count;

                $subjects = $this->extractTerms(
                    $profile->subjects ?? ''
                );

                $skills = $this->extractTerms(
                    $profile->skills ?? ''
                );

                $specialization = $this->extractTerms(
                    $profile->specialization ?? ''
                );

                $education = $this->extractTerms(
                    $profile->education_level ?? ''
                );

                $matchedSubject = false;

                if ($subject !== '') {
                    $matchedSubject = $this->matchesText(
                        $subject,
                        $profile->subjects ?? ''
                    ) || $this->matchesText(
                        $subject,
                        $profile->specialization ?? ''
                    );
                }

                $matchedSkills = [];

                foreach ($requestedSkills as $requestedSkill) {
                    if (
                        in_array($requestedSkill, $skills, true) ||
                        in_array($requestedSkill, $subjects, true) ||
                        in_array($requestedSkill, $specialization, true)
                    ) {
                        $matchedSkills[] = $requestedSkill;
                    }
                }

                $matchedObjectiveTerms = [];

                foreach ($objectiveTerms as $term) {
                    if (
                        in_array($term, $subjects, true) ||
                        in_array($term, $skills, true) ||
                        in_array($term, $specialization, true) ||
                        in_array($term, $education, true)
                    ) {
                        $matchedObjectiveTerms[] = $term;
                    }
                }

                /*
                 * Matching weights:
                 * Subject match:       50 points
                 * Skills match:        30 points
                 * Learning objective:  20 points
                 */

                $subjectScore = $subject === ''
                    ? 0
                    : ($matchedSubject ? 50 : 0);

                $skillsScore = count($requestedSkills) > 0
                    ? (30 * count($matchedSkills)
                        / count($requestedSkills))
                    : 0;

                $objectiveScore = count($objectiveTerms) > 0
                    ? (20 * count($matchedObjectiveTerms)
                        / count($objectiveTerms))
                    : 0;

                $totalWeight = ($subject !== '' ? 50 : 0)
                    + (count($requestedSkills) > 0 ? 30 : 0)
                    + (count($objectiveTerms) > 0 ? 20 : 0);

                $score = $totalWeight > 0
                    ? round(
                        (($subjectScore + $skillsScore + $objectiveScore)
                        / $totalWeight) * 100
                    )
                    : 0;

                $reasons = [];

                if ($matchedSubject) {
                    $reasons[] = 'Matches your subject';
                }

                if (count($matchedSkills) > 0) {
                    $reasons[] = 'Matches skills: '
                        . implode(', ', $matchedSkills);
                }

                if (count($matchedObjectiveTerms) > 0) {
                    $reasons[] = 'Matches learning topics: '
                        . implode(', ', $matchedObjectiveTerms);
                }

                $profile->match_score = $score;
                $profile->match_reasons = $reasons;
                $profile->matched_skills = $matchedSkills;

                return $profile;
            });

        // Show strongest skill and objective matches first.
        if (
            $subject !== '' ||
            $skillsInput !== '' ||
            $objective !== ''
        ) {
            $tutors = $tutors
                ->sortByDesc('match_score')
                ->values();
        }

        // Paginate the ranked results while keeping search criteria.
        $page = max(1, (int) $request->query('page', 1));
        $perPage = 9;

        $paginatedTutors = new LengthAwarePaginator(
            $tutors->slice(($page - 1) * $perPage, $perPage)->values(),
            $tutors->count(),
            $perPage,
            $page,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('student.find-tutors', [
            'tutors' => $paginatedTutors,
            'subject' => $subject,
            'skillsInput' => $skillsInput,
            'objective' => $objective,
        ]);
    }

    private function extractTerms(string $text): array
    {
        $text = Str::lower($text);

        $terms = preg_split('/[,;\n]+/', $text) ?: [];

        return collect($terms)
            ->map(fn ($term) => trim($term))
            ->filter(fn ($term) => $term !== '')
            ->unique()
            ->values()
            ->all();
    }

    private function matchesText(
        string $search,
        string $profileText
    ): bool {
        $search = Str::lower(trim($search));
        $profileText = Str::lower($profileText);

        if ($search === '' || $profileText === '') {
            return false;
        }

        $profileTerms = $this->extractTerms($profileText);

        return in_array($search, $profileTerms, true)
            || Str::contains($profileText, $search);
    }
}
