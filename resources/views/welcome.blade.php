
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PascalEDU | Find Your Perfect Tutor</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap"
          rel="stylesheet">

    <!-- Your CSS file -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">

            <a href="/" class="brand">PascalEDU<span>.</span></a>

            <button class="navbar-toggler bg-light" type="button"
                    data-bs-toggle="collapse" data-bs-target="#mainNav"
                    aria-controls="mainNav" aria-expanded="false"
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <div class="navbar-nav ms-auto align-items-lg-center">
                    <a class="nav-link" href="#benefits">Why PascalEDU</a>
                    <a class="nav-link" href="#how-it-works">How it works</a>
                    <a class="nav-button" href="{{ url('/register') }}">
                        Get started ↗
                    </a>
                </div>
            </div>

        </div>
    </nav>

    <!-- Main hero section -->
    <main>
        <section class="hero">
            <div class="container">
                <div class="row align-items-center g-4">

                    <div class="col-lg-6">
                        <span class="eyebrow">PERSONALISED LEARNING</span>

                        <h1>
                            Find the right tutor.<br>
                            <span>Reach your goals.</span>
                        </h1>

                        <p class="hero-description">
                            Learning is personal. PascalEDU connects you
                            with tutors whose skills and expertise match
                            your learning objectives.
                        </p>

                        <a href="{{ url('/register') }}" class="primary-button">
                            Find your tutor ↗
                        </a>

                        <a href="#how-it-works" class="secondary-link">
                            See how it works →
                        </a>
                    </div>

                    <!-- Tutor matching preview card -->
                    <div class="col-lg-6">
                        <div class="hero-art">
                            <div class="art-circle"></div>

                            <div class="learning-card">

                                <div class="d-flex justify-content-between
                                            align-items-center mb-4">
                                    <span class="card-label">
                                        YOUR MATCH PREVIEW
                                    </span>
                                    <span>✦</span>
                                </div>

                                <div class="d-flex align-items-center gap-3 mb-4">
                                    <div class="tutor-avatar">👩🏻‍🏫</div>

                                    <div>
                                        <h5 class="mb-1 fw-bold">
                                            Your ideal tutor
                                        </h5>
                                        <small class="text-secondary">
                                            Matched to your goals
                                        </small>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between
                                            align-items-center mb-3">
                                    <span class="card-label">
                                        SKILL ALIGNMENT
                                    </span>
                                    <span class="match-score">
                                        Goal-based
                                    </span>
                                </div>

                                <div class="mb-3">
                                    <span class="skill-tag">Your skills</span>
                                    <span class="skill-tag">Your goals</span>
                                    <span class="skill-tag">Your schedule</span>
                                </div>

                                <hr style="border-color: #E9DFD5;">

                                <p class="mb-0 text-secondary"
                                   style="font-size: 13px; line-height: 1.7;">
                                    A more thoughtful way to find support
                                    for your learning journey.
                                </p>

                            </div>

                            <div class="floating-note">
                                ✦ &nbsp; Learning that fits you
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Benefits section -->
        <section class="benefits" id="benefits">
            <div class="container">
                <div class="row g-4">

                    <div class="col-md-4">
                        <div class="benefit">
                            <span class="benefit-number">
                                01 / YOUR GOALS
                            </span>
                            <h3>Learning with purpose</h3>
                            <p>
                                Define what you want to learn and find
                                support that fits your objectives.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="benefit">
                            <span class="benefit-number">
                                02 / SMART MATCHING
                            </span>
                            <h3>More relevant tutors</h3>
                            <p>
                                Discover tutors based on relevant skills,
                                expertise and learning needs.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4" id="how-it-works">
                        <div class="benefit">
                            <span class="benefit-number">
                                03 / YOUR JOURNEY
                            </span>
                            <h3>Progress your way</h3>
                            <p>
                                Bring your learning goals into focus and
                                take the next step with confidence.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <div class="container d-flex flex-wrap justify-content-between
                    align-items-center gap-3">

            <a href="/" class="brand">PascalEDU<span>.</span></a>

            <span>Learn with purpose. Grow with confidence.</span>

            <span>© {{ date('Y') }} PascalEDU</span>

        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
