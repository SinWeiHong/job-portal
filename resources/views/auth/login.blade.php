<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Job Seeker Login | Job Portal</title>

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

        .login-container {
            width: 100%;
            max-width: 440px;
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

        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 15px;
            outline: none;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .form-options {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .remember-option {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .form-options a,
        .register-text a {
            color: #2563eb;
            font-weight: 600;
            text-decoration: none;
        }

        .form-options a:hover,
        .register-text a:hover {
            text-decoration: underline;
        }

        .login-button {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 8px;
            background: #2563eb;
            color: #ffffff;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .login-button:hover {
            background: #1d4ed8;
        }

        .register-text {
            margin-top: 22px;
            color: #6b7280;
            text-align: center;
        }

        .security-note {
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
    <main class="login-container">
        <div class="portal-name">Job Portal Website</div>

        <h1>Welcome Back</h1>

        <p class="subtitle">
            Log in to access your job seeker account.
        </p>

        <div class="security-note">
            Enter your registered email address and password securely.
        </div>

        <!--
            Week 1 Commit 1 only creates the login interface.
            Authentication will be implemented in the next commits.
        -->
        <form>
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
                    autocomplete="current-password"
                    required
                >
            </div>

            <div class="form-options">
                <label class="remember-option" for="remember">
                    <input
                        type="checkbox"
                        id="remember"
                        name="remember"
                    >

                    Remember me
                </label>

                <a href="#">Forgot password?</a>
            </div>

            <!-- Changed to submit in the next commit -->
            <button
                type="button"
                class="login-button"
            >
                Log In
            </button>
        </form>

        <p class="register-text">
            Do not have an account?

            <a href="{{ url('/register') }}">
                Register here
            </a>
        </p>
    </main>
</body>
</html>