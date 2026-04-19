<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile – SaaS Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Optional: Inter / Roboto font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #4C6EF5;
            --primary-dark: #3B5BDB;
            --bg-page: #F3F4F8;
            --text-main: #111827;
            --text-muted: #6B7280;
            --border-soft: #E5E7EB;
            --shadow-soft: 0 18px 45px rgba(15, 23, 42, 0.10);
            --radius-card: 18px;
            --radius-input: 10px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: "Inter", "Roboto", -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            background: var(--bg-page);
            color: var(--text-main);
        }

        /* Top Cover Banner */
        .cover-banner {
            position: relative;
            width: 100%;
            height: 220px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            overflow: hidden;
        }

        .cover-banner-shape {
            position: absolute;
            opacity: 0.2;
            background: rgba(255, 255, 255, 0.5);
        }

        .cover-banner-shape.circle-lg {
            width: 260px;
            height: 260px;
            border-radius: 999px;
            top: -80px;
            left: -40px;
        }

        .cover-banner-shape.circle-md {
            width: 200px;
            height: 200px;
            border-radius: 999px;
            top: -60px;
            right: 80px;
        }

        .cover-banner-shape.pill {
            width: 300px;
            height: 90px;
            border-radius: 999px;
            bottom: -40px;
            right: -60px;
            transform: rotate(-18deg);
        }

        .cover-banner-shape.poly {
            width: 220px;
            height: 220px;
            top: 60px;
            right: 35%;
            border-radius: 30% 70% 60% 40%;
        }

        .change-cover-btn {
            position: absolute;
            top: 18px;
            right: 24px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            font-size: 0.85rem;
            color: #ffffff;
            background: transparent;
            border-radius: 999px;
            border: 1px solid rgba(255, 255, 255, 0.85);
            cursor: pointer;
            backdrop-filter: blur(6px);
        }

        .change-cover-btn svg {
            width: 14px;
            height: 14px;
        }

        /* Main container / card */
        .profile-page-container {
            max-width: 1120px;
            margin: -80px auto 40px;
            padding: 0 16px 32px;
        }

        .profile-card {
            background: #ffffff;
            border-radius: var(--radius-card);
            box-shadow: var(--shadow-soft);
            padding: 32px 36px 28px;
        }

        @media (max-width: 768px) {
            .profile-card {
                padding: 24px 20px 22px;
            }
        }

        .profile-card-title {
            font-size: 1.35rem;
            font-weight: 600;
            margin-bottom: 24px;
        }

        /* Top profile row */
        .profile-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 24px;
        }

        .profile-avatar-area {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .profile-avatar {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #ffffff;
            box-shadow: 0 12px 25px rgba(15, 23, 42, 0.25);
        }

        .profile-name-block {
            display: flex;
            flex-direction: column;
        }

        .profile-name-block .name {
            font-weight: 600;
            font-size: 1rem;
        }

        .profile-name-block .tagline {
            font-size: 0.85rem;
            color: var(--text-muted);
        }

        .profile-picture-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .btn {
            border-radius: 999px;
            border: none;
            padding: 9px 18px;
            font-size: 0.86rem;
            font-weight: 500;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            white-space: nowrap;
        }

        .btn-primary {
            background: linear-gradient(135deg, #6366F1, #4F46E5);
            color: #ffffff;
            box-shadow: 0 12px 20px rgba(79, 70, 229, 0.35);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #4F46E5, #4338CA);
        }

        .btn-secondary {
            background: #F3F4F6;
            color: #111827;
        }

        .btn-secondary:hover {
            background: #E5E7EB;
        }

        /* Form grid layout */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            column-gap: 24px;
            row-gap: 18px;
            margin-top: 10px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .label {
            font-size: 0.86rem;
            font-weight: 500;
            color: var(--text-muted);
            margin-bottom: 6px;
        }

        .input,
        .select,
        .textarea {
            width: 100%;
            font-size: 0.9rem;
            padding: 0.6rem 0.75rem;
            border-radius: var(--radius-input);
            border: 1px solid var(--border-soft);
            background: #ffffff;
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
            outline: none;
            transition: border-color 0.15s ease, box-shadow 0.15s ease, background-color 0.15s ease;
        }

        .input:focus,
        .select:focus,
        .textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 1px rgba(76, 110, 245, 0.18);
        }

        .textarea {
            min-height: 110px;
            resize: vertical;
        }

        /* Password with toggle */
        .input-with-icon {
            position: relative;
        }

        .input-with-icon .input {
            padding-right: 2.2rem;
        }

        .icon-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            width: 22px;
            height: 22px;
            border-radius: 999px;
            border: none;
            background: transparent;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #9CA3AF;
        }

        /* Phone + country layout */
        .phone-group {
            display: flex;
            gap: 8px;
        }

        .phone-group .country-select {
            flex: 0 0 95px;
        }

        .phone-group .phone-input {
            flex: 1;
        }

        /* Email verified indicator */
        .input-with-status {
            position: relative;
        }

        .input-with-status .input {
            padding-right: 2.2rem;
        }

        .status-indicator {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            border-radius: 999px;
            background: #10B981;
        }

        .status-indicator svg {
            width: 12px;
            height: 12px;
            color: #ffffff;
        }

        /* DOB layout */
        .dob-row {
            display: grid;
            grid-template-columns: 1.05fr 0.7fr 0.9fr;
            gap: 8px;
        }

        /* Social media + Add More Link */
        .social-row {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .social-more-link {
            text-align: right;
            font-size: 0.86rem;
            color: var(--primary);
            cursor: pointer;
            align-self: center;
            justify-self: end;
            grid-column: 3 / 4;
        }

        /* Bottom primary button */
        .form-actions {
            margin-top: 22px;
        }

        .edit-profile-btn {
            padding-inline: 22px;
        }

        @media (max-width: 900px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            .social-row {
                grid-template-columns: 1fr;
            }
            .social-more-link {
                justify-self: flex-start;
                text-align: left;
                margin-top: 4px;
            }
            .dob-row {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }
        }
    </style>
</head>
<body>

    <!-- Top Cover Banner -->
    <div class="cover-banner">
        <div class="cover-banner-shape circle-lg"></div>
        <div class="cover-banner-shape circle-md"></div>
        <div class="cover-banner-shape pill"></div>
        <div class="cover-banner-shape poly"></div>

        <button class="change-cover-btn">
            <!-- Camera icon (SVG) -->
            <svg viewBox="0 0 20 20" fill="none">
                <path d="M7.5 4.5L8.7 3h2.6l1.2 1.5h2c.8 0 1.5.7 1.5 1.5v7A1.5 1.5 0 0 1 16 14.5H4A1.5 1.5 0 0 1 2.5 13V6A1.5 1.5 0 0 1 4 4.5h3.5Z"
                      stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                <circle cx="10" cy="9.5" r="3" stroke="currentColor" stroke-width="1.3"/>
            </svg>
            <span>Change Cover</span>
        </button>
    </div>

    <!-- Main Profile Editing Card -->
    <div class="profile-page-container">
        <div class="profile-card">
            <div class="profile-card-title">Edit Profile</div>

            <!-- Profile picture + actions -->
            <div class="profile-header-row">
                <div class="profile-avatar-area">
                    <img src="https://via.placeholder.com/150x150.png?text=User" alt="Profile" class="profile-avatar">
                    <div class="profile-name-block">
                        <span class="name">Kevin Patel</span>
                        <span class="tagline">Product Designer</span>
                    </div>
                </div>
                <div class="profile-picture-actions">
                    <button class="btn btn-primary" type="button">
                        Upload New Profile Picture
                    </button>
                    <button class="btn btn-secondary" type="button">
                        Remove Profile Picture
                    </button>
                </div>
            </div>

            <!-- Form Grid -->
            <form>
                <div class="form-grid">

                    <!-- Row 1 -->
                    <div class="form-group">
                        <label class="label" for="username">Username</label>
                        <input id="username" class="input" type="text" value="kevinpatel.233">
                    </div>
                    <div class="form-group">
                        <label class="label" for="password">Password</label>
                        <div class="input-with-icon">
                            <input id="password" class="input" type="password" value="password123">
                            <button type="button" class="icon-toggle" id="togglePassword" aria-label="Toggle password visibility">
                                <!-- Eye icon -->
                                <svg viewBox="0 0 20 20" fill="none">
                                    <path d="M2 10s2.5-4.5 8-4.5S18 10 18 10s-2.5 4.5-8 4.5S2 10 2 10Z"
                                          stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/>
                                    <circle cx="10" cy="10" r="2.5" stroke="currentColor" stroke-width="1.3"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Row 2 -->
                    <div class="form-group">
                        <label class="label" for="first_name">First Name</label>
                        <input id="first_name" class="input" type="text" value="Kevin">
                    </div>
                    <div class="form-group">
                        <label class="label" for="last_name">Last Name</label>
                        <input id="last_name" class="input" type="text" value="Patel">
                    </div>

                    <!-- Row 3 -->
                    <div class="form-group">
                        <label class="label" for="phone_number">Phone Number</label>
                        <div class="phone-group">
                            <select class="select country-select" id="phone_country">
                                <option selected>IN</option>
                                <option>US</option>
                                <option>UK</option>
                            </select>
                            <input id="phone_number" class="input phone-input" type="text" value="+91 94256 65025">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="label" for="email">Email Address</label>
                        <div class="input-with-status">
                            <input id="email" class="input" type="email" value="kevin.patel1@gmail.com">
                            <span class="status-indicator" title="Verified email">
                                <!-- Check icon -->
                                <svg viewBox="0 0 16 16" fill="none">
                                    <path d="M4 8.2 6.4 10.5 12 4.8"
                                          stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </div>
                    </div>

                    <!-- Row 4 (Address full width) -->
                    <div class="form-group full-width">
                        <label class="label" for="address">Address</label>
                        <input id="address" class="input" type="text"
                               value="A - 1002 Alpha Plus, Raiya Telephone Exchange">
                    </div>

                    <!-- Row 5 -->
                    <div class="form-group">
                        <label class="label" for="country">Country</label>
                        <select id="country" class="select">
                            <option selected>India</option>
                            <option>United States</option>
                            <option>United Kingdom</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="label" for="state">State</label>
                        <select id="state" class="select">
                            <option selected>Gujrat</option>
                            <option>Maharashtra</option>
                            <option>Delhi</option>
                        </select>
                    </div>

                    <!-- Row 6 -->
                    <div class="form-group">
                        <label class="label" for="city">City</label>
                        <input id="city" class="input" type="text" value="Rajkot">
                    </div>
                    <div class="form-group">
                        <label class="label" for="zip">Zip Code</label>
                        <input id="zip" class="input" type="text" value="360005">
                    </div>

                    <!-- Row 7 -->
                    <div class="form-group">
                        <label class="label">DOB (Date of Birth)</label>
                        <div class="dob-row">
                            <select class="select">
                                <option>January</option>
                                <option>February</option>
                                <option>March</option>
                                <option>April</option>
                                <option>May</option>
                                <option selected>June</option>
                                <option>July</option>
                            </select>
                            <select class="select">
                                <option>1</option>
                                <option>10</option>
                                <option selected>26</option>
                                <option>30</option>
                            </select>
                            <select class="select">
                                <option>1999</option>
                                <option selected>2000</option>
                                <option>2001</option>
                                <option>2002</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="label" for="gender">Gender</label>
                        <select id="gender" class="select">
                            <option selected>Male</option>
                            <option>Female</option>
                            <option>Other</option>
                        </select>
                    </div>

                    <!-- Social Media Links Section (full width) -->
                    <div class="form-group full-width">
                        <label class="label">Social Media</label>
                        <div class="social-row">
                            <input class="input" type="text" placeholder="LinkedIn" value="linkedin/kevin/patel">
                            <input class="input" type="text" placeholder="Twitter" value="twitter.com/kevinpatel">
                            <input class="input" type="text" placeholder="Facebook" value="facebook.com/kevinpatel">
                            <span class="social-more-link">+ Add More Link</span>
                        </div>
                    </div>

                    <!-- Bio Section -->
                    <div class="form-group full-width">
                        <label class="label" for="bio">Bio</label>
                        <textarea id="bio" class="textarea" placeholder="add bio here...">add bio here...</textarea>
                    </div>
                </div>

                <!-- Action Button -->
                <div class="form-actions">
                    <button class="btn btn-primary edit-profile-btn" type="submit">
                        Edit Profile
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Password visibility toggle
        (function () {
            const toggleBtn = document.getElementById('togglePassword');
            const pwdInput = document.getElementById('password');
            if (!toggleBtn || !pwdInput) return;

            toggleBtn.addEventListener('click', function () {
                const isPassword = pwdInput.type === 'password';
                pwdInput.type = isPassword ? 'text' : 'password';
            });
        })();
    </script>
</body>
</html>
