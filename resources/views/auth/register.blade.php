<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Job Seeker Registration | Job Portal</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 16px;
            font-family: Arial, sans-serif;
            background: #f3f6fb;
            color: #1f2937;
        }

        .registration-container {
            width: 100%;
            max-width: 480px;
            padding: 36px;
            background: #ffffff;
            border-radius: 14px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .portal-name {
            margin-bottom: 8px;
            color: #2563eb;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
        }

        h1 {
            margin-bottom: 8px;
            font-size: 28px;
            text-align: center;
        }

        .subtitle {
            margin-bottom: 28px;
            color: #6b7280;
            line-height: 1.5;
            text-align: center;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: 600;
        }

        input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
        }

        input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .register-button {
            width: 100%;
            margin-top: 6px;
            padding: 13px;
            border: none;
            border-radius: 8px;
            background: #2563eb;
            color: #ffffff;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .register-button:hover {
            background: #1d4ed8;
        }

        .login-text {
            margin-top: 22px;
            color: #6b7280;
            text-align: center;
        }

        .login-text a {
            color: #2563eb;
            font-weight: 600;
            text-decoration: none;
        }

        .login-text a:hover {
            text-decoration: underline;
        }

        .role-note {
            margin-bottom: 20px;
            padding: 11px 13px;
            border-radius: 8px;
            background: #eff6ff;
            color: #1e40af;
            font-size: 14px;
            line-height: 1.4;
        }
    </style>
</head>

<body>
    <main class="registration-container">
        <div class="portal-name">Job Portal Website</div>

        <h1>Create an Account</h1>

        <p class="subtitle">
            Register as a job seeker to search and apply for jobs.
        </p>

        <div class="role-note">
            This registration page is for job seekers.
        </div>

        <!--
            Week 1 Commit 1 only creates the registration interface.
            Form submission will be implemented in the next commit.
        -->
        <form>
            <div class="form-group">
                <label for="name">Full Name</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Enter your full name"
                    autocomplete="name"
                    required
                >
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="Enter your email address"
                    autocomplete="email"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter your password"
                    autocomplete="new-password"
                    required
                >
            </div>

            <div class="form-group">
                <label for="password_confirmation">
                    Confirm Password
                </label>

                <input
                    type="password"
                    id="password_confirmation"
                    name="password_confirmation"
                    placeholder="Enter your password again"
                    autocomplete="new-password"
                    required
                >
            </div>

            <!-- Changed to submit in Commit 2 -->
            <button
                type="button"
                class="register-button"
            >
                Register
            </button>
        </form>

        <p class="login-text">
            Already have an account?
            <a href="#">Log in here</a>
        </p>
    </main>
</body>
</html>