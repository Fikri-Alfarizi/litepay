<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - LitePay</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'DM Sans', sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            background-color: #ffffff;
            overflow: hidden;
        }

        .left-section {
            width: 50%;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            background: #fff;
            overflow-y: auto;
        }

        .register-container {
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            color: #4F46E5;
            font-weight: 700;
            font-size: 18px;
            letter-spacing: -0.5px;
        }

        .logo-icon {
            background-color: #4F46E5;
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-size: 16px;
        }

        h1 {
            font-size: 32px;
            color: #111827;
            margin-bottom: 10px;
            font-weight: 700;
        }

        .subtitle {
            color: #6B7280;
            font-size: 14px;
            margin-bottom: 30px;
        }

        .btn-google {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px;
            background: white;
            border: 1px solid #E5E7EB;
            border-radius: 6px;
            color: #374151;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s;
            margin-bottom: 20px;
        }

        .btn-google:hover {
            background-color: #F9FAFB;
        }

        .btn-google img {
            width: 18px;
            margin-right: 10px;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 20px 0;
            color: #9CA3AF;
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #E5E7EB;
        }

        .divider::before {
            margin-right: 15px;
        }

        .divider::after {
            margin-left: 15px;
        }

        .form-group {
            text-align: left;
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: #1F2937;
            margin-bottom: 8px;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #E5E7EB;
            border-radius: 6px;
            font-size: 14px;
            color: #374151;
            transition: border-color 0.2s;
            background-color: #FAFAFA;
        }

        .form-control::placeholder {
            color: #D1D5DB;
        }

        .form-control:focus {
            outline: none;
            border-color: #4F46E5;
            background-color: white;
        }

        .form-control.error {
            border-color: #DC2626;
        }

        .form-row {
            display: flex;
            gap: 15px;
        }

        .form-row .form-group {
            flex: 1;
        }

        .checkbox-group {
            display: flex;
            align-items: flex-start;
            color: #1F2937;
            font-weight: 500;
            font-size: 13px;
            margin-bottom: 25px;
            text-align: left;
        }

        .checkbox-group input {
            margin-right: 8px;
            margin-top: 2px;
            width: 16px;
            height: 16px;
            cursor: pointer;
            accent-color: #4F46E5;
            flex-shrink: 0;
        }

        .checkbox-group a {
            color: #EC4899;
            text-decoration: none;
        }

        .checkbox-group a:hover {
            text-decoration: underline;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background-color: #4F46E5;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
            transition: background 0.2s;
        }

        .btn-submit:hover {
            background-color: #4338CA;
        }

        .footer-text {
            margin-top: 30px;
            font-size: 14px;
            color: #6B7280;
        }

        .footer-text a {
            color: #EC4899;
            text-decoration: none;
            font-weight: 500;
        }

        .alert-error {
            background-color: #FEE2E2;
            color: #DC2626;
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: left;
        }

        .right-section {
            width: 50%;
            height: 100%;
            background-color: #EEF2FF;
            display: flex;
            flex-direction: column;
            position: relative;
            padding: 40px;
        }

        .right-header {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: auto;
        }

        .academy-branding {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            text-align: right;
        }

        .academy-logo {
            font-weight: 700;
            color: #374151;
            display: flex;
            align-items: center;
            font-size: 16px;
            margin-bottom: 10px;
        }

        .academy-logo i {
            margin-right: 8px;
        }

        .academy-desc {
            font-size: 14px;
            color: #6B7280;
            max-width: 300px;
            line-height: 1.5;
            margin-bottom: 15px;
        }

        .btn-academy {
            padding: 8px 16px;
            background: transparent;
            border: 1px solid #D1D5DB;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 700;
            color: #374151;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-academy:hover {
            border-color: #374151;
            background: rgba(0, 0, 0, 0.02);
        }

        .illustration-container {
            flex: 1;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            margin-bottom: 20px;
        }

        .illustration-container img {
            max-width: 80%;
            height: auto;
            filter: drop-shadow(0 10px 15px rgba(0, 0, 0, 0.05));
        }

        .features-list {
            margin-top: auto;
            margin-bottom: 40px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            font-size: 14px;
            color: #374151;
        }

        .feature-item i {
            width: 24px;
            height: 24px;
            background-color: #4F46E5;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 10px;
            margin-right: 12px;
            flex-shrink: 0;
        }

        @media (max-width: 900px) {
            .right-section {
                display: none;
            }

            .left-section {
                width: 100%;
            }
        }
    </style>
</head>

<body>

    <div class="left-section">
        <div class="register-container">

            <h1>Create Account</h1>
            <p class="subtitle">Start managing your payments today</p>

            @if ($errors->any())
                <div class="alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <button class="btn-google" type="button">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google Logo">
                Sign up with Google
            </button>

            <div class="divider">OR REGISTER WITH EMAIL</div>

            <form action="{{ route('register.submit') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="name" class="form-control @error('name') error @enderror"
                        placeholder="John Doe" value="{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" class="form-control @error('email') error @enderror"
                        placeholder="john@example.com" value="{{ old('email') }}" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control @error('password') error @enderror"
                        placeholder="Min. 8 characters" required>
                </div>

                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control"
                        placeholder="Confirm your password" required>
                </div>

                <label class="checkbox-group">
                    <input type="checkbox" name="terms" required>
                    <span>I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a></span>
                </label>

                <button type="submit" class="btn-submit">Create Account</button>
            </form>

            <div class="footer-text">
                Already have an account? <a href="{{ route('login') }}">Log in</a>
            </div>
        </div>
    </div>

    <div class="right-section">
        <div class="right-header">
            <div class="academy-branding">
                <div class="academy-logo">
                    <i class="fas fa-rocket"></i> Get Started
                </div>
                <p class="academy-desc">Join thousands of businesses using LitePay for secure payment processing.</p>
                <a href="{{ route('store.index') }}" class="btn-academy">Explore Features</a>
            </div>
        </div>

        <div class="illustration-container">
            <img src="{{ asset('img/working-illustration.png') }}" alt="Working Illustration">
        </div>
    </div>

</body>

</html>