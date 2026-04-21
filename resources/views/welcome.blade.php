<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="IFSU Online-Based Attendance and Student Fee Monitoring System - Manage student records, track payments, monitor attendance, and streamline college operations.">
    <title>IFSU | Online-Based Attendance & Student Fee Monitoring System</title>

    <!-- Fonts -->

    <!-- Styles -->
    <link rel="stylesheet" href="css/landing.css">
    <link rel="stylesheet" href="css/buttons-text-hover-effect.css">

    <!-- Sticky header scroll behavior -->
    <!-- Login Modal Script -->
</head>
<body>
    <main class="hero" role="main">
        <div class="hero__inner">
            <!-- Header -->
            <header class="header" role="banner" id="header" >
                <a class="header__brand" style="gap: 10px;" aria-label="IFUGAO STATE UNIVERSITY - Home">
                    <img
                        src="{{ asset('images/landing/ifsu-logo.png') }}"
                        alt="IFUGAO STATE UNIVERSITY Logo"
                        class="header__logo"
                        width="56"
                        height="56"
                    >
                    <h3 >IFUGAO STATE UNIVERSITY</h3>
                </a>
                <nav class="header__nav" role="navigation" aria-label="Main navigation">
                    <button type="button" class="header__nav-link" id="loginBtn">Login</button>
                    <a href="#about" class="header__nav-link">About</a>
                </nav>
            </header>

            <!-- Hero Content -->
            <section class="hero__content" aria-labelledby="hero-title">
                <h1 id="hero-title" class="hero__title">
                    IFSU ONTIME:
                    Students Real-Time Event Attendance and
                    Fee Monitoring System
                </h1>
                <p class="hero__subtext">
                    Manage student records, track payments, monitor attendance, and streamline college oranization operations all in one place.
                </p>
                <div class="hero__cta">
                    <button type="button" class="btn btn--primary" id="loginBtnCta">
                        <h3>Login</h3>
                    </button>
                </div>
            </section>
        </div>

        <!-- Accreditation / Ranking Section -->
        <section class="accreditation" aria-label="University accreditations and rankings">
            <div class="accreditation__inner">
                <div class="accreditation__logos">
                    <img
                        src="images/landing/accreditation-logos.png"
                        alt="IFSU accreditations: ISO 9001-2015 Certified, QS World University Rankings Asia, QS Stars Rating System, THE Impact Rankings, WURI, AppliedHE, UI GreenMetric"
                        class="accreditation__strip"
                        loading="lazy"
                    >
                </div>
            </div>
        </section>
    </main>

    <!-- About Section (for Learn more / About links) -->
    <section id="about" class="about" aria-labelledby="about-title">
        <div class="about__inner">
            <h2 id="about-title" class="about__title">About the System</h2>
            <p class="about__text">
                The Online-Based Attendance and Student Fee Monitoring System streamlines administrative tasks for IFSU Collage Organization.
                Track student attendance, manage fee payments, and maintain records efficiently in one centralized platform.
            </p>
        </div>
    </section>

    <!-- Login Role Selection Modal -->
    <div class="login-modal-overlay" id="loginModal" aria-hidden="true">
        <div class="login-modal">
            <header class="login-modal__header">
                <div class="login-modal__brand">
                    <img
                        src="{{ asset('images/landing/ifsu-logo.png') }}"
                        alt="IFSU Logo"
                        class="login-modal__logo"
                    >
                    <div class="login-modal__title-top">IFUGAO STATE UNIVERSITY</div>
                </div>
                <button class="login-modal__close" id="closeModal" aria-label="Close modal">&times;</button>
            </header>
            <hr class="login-modal__divider">
            <div class="login-modal__body">
                <div class="login-modal__content">
                    <h2 class="login-modal__heading">Select Your Role</h2>
                    <p class="login-modal__text">Choose your login type to access the system.</p>
                </div>
                <div class="login-modal__illustration-wrapper">
                    <img
                        src="images/landing/Hero_admin1.png"
                        alt="Admin User Illustration"
                        class="login-modal__illustration"
                    >
                </div>
            </div>
            <hr class="login-modal__divider login-modal__divider--buttons">
            <footer class="login-modal__footer">
                <a href="{{ route('usersLogin', ['role' => 'super_admin']) }}" class="login-modal__role login-modal__role--primary">Super Admin Login</a>
                <a href="{{ route('usersLogin', ['role' => 'admin']) }}" class="login-modal__role login-modal__role--primary">Admin Login</a>
                <a href="{{ route('studentLogin') }}" class="login-modal__role login-modal__role--primary">Officer Login</a>
                <a href="{{ route('studentLogin') }}" class="login-modal__role login-modal__role--primary">Student Login</a>
            </footer>
        </div>
    </div>

</body>
<script src="js/SelectRole.js"></script>
</html>
