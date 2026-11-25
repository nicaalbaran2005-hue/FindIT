<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FindIT — Lost and Found Management System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; min-height: 100vh; background: #f0f7ff; display: flex; flex-direction: column; }

        /* ── NAVBAR ─────────────────────────── */
        .navbar {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid #e8edf3;
            padding: 0 48px; height: 58px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 100;
        }
        .nav-brand { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .nav-brand-icon { width: 34px; height: 34px; background: #185FA5; border-radius: 9px; display: flex; align-items: center; justify-content: center; }
        .nav-brand-icon i { color: #fff; font-size: 17px; }
        .nav-brand-name { font-size: 17px; font-weight: 700; color: #0f172a; }
        .nav-brand-name span { color: #185FA5; }
        .nav-links { display: flex; align-items: center; gap: 6px; }
        .nav-link { padding: 7px 14px; border-radius: 8px; font-size: 13.5px; font-weight: 500; color: #475569; text-decoration: none; transition: all 0.15s; }
        .nav-link:hover { background: #f1f5f9; color: #1e293b; }
        .nav-btn { padding: 8px 18px; border-radius: 8px; font-size: 13.5px; font-weight: 600; background: #185FA5; color: #fff; text-decoration: none; transition: all 0.15s; }
        .nav-btn:hover { background: #145090; }

        /* ── MAIN ───────────────────────────── */
        .main { flex: 1; display: flex; align-items: center; padding: 40px 48px; gap: 60px; max-width: 1200px; margin: 0 auto; width: 100%; }

        /* ── LEFT CONTENT ───────────────────── */
        .left { flex: 1; }
        .hero-badge { display: inline-flex; align-items: center; gap: 6px; background: #EBF3FC; color: #185FA5; padding: 5px 13px; border-radius: 20px; font-size: 12px; font-weight: 600; margin-bottom: 22px; border: 1px solid #bfdbfe; }
        .hero-title { font-size: 46px; font-weight: 800; line-height: 1.15; color: #0f172a; margin-bottom: 18px; letter-spacing: -1px; }
        .hero-title span { color: #185FA5; }
        .hero-sub { font-size: 16px; color: #64748b; line-height: 1.7; margin-bottom: 32px; max-width: 480px; }

        .features-list { display: flex; flex-direction: column; gap: 12px; margin-bottom: 32px; }
        .feature-item { display: flex; align-items: center; gap: 12px; }
        .feature-icon { width: 36px; height: 36px; border-radius: 9px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
        .feature-icon i { font-size: 17px; }
        .feature-text { font-size: 13.5px; color: #374151; font-weight: 500; }

        .hero-stats { display: flex; gap: 28px; }
        .stat-val { font-size: 22px; font-weight: 700; color: #0f172a; }
        .stat-label { font-size: 11px; color: #94a3b8; margin-top: 1px; }

        /* ── LOGIN CARD ─────────────────────── */
        .login-card {
            background: #fff; border-radius: 20px;
            border: 1px solid #e8edf3;
            padding: 36px; width: 400px; flex-shrink: 0;
            box-shadow: 0 8px 32px rgba(0,0,0,0.06);
        }
        .card-header { text-align: center; margin-bottom: 24px; }
        .card-icon { width: 52px; height: 52px; background: #EBF3FC; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin: 0 auto 12px; }
        .card-icon i { color: #185FA5; font-size: 26px; }
        .card-title { font-size: 20px; font-weight: 700; color: #0f172a; margin-bottom: 4px; }
        .card-sub { font-size: 13px; color: #64748b; }

        .form-group { margin-bottom: 14px; }
        .form-label { display: block; font-size: 13px; font-weight: 500; color: #374151; margin-bottom: 5px; }
        .input-wrap { position: relative; }
        .input-icon { position: absolute; left: 11px; top: 50%; transform: translateY(-50%); color: #94a3b8; font-size: 16px; pointer-events: none; }
        .form-input { width: 100%; padding: 10px 12px 10px 36px; border: 1.5px solid #e2e8f0; border-radius: 9px; font-size: 13px; color: #1e293b; font-family: 'Inter', sans-serif; background: #f8fafc; transition: all 0.15s; }
        .form-input:focus { outline: none; border-color: #185FA5; background: #fff; box-shadow: 0 0 0 3px rgba(24,95,165,0.1); }
        .input-action { position: absolute; right: 11px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #94a3b8; font-size: 16px; padding: 0; }
        .input-action:hover { color: #475569; }

        .form-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 18px; }
        .form-check { display: flex; align-items: center; gap: 7px; font-size: 13px; color: #475569; cursor: pointer; }
        .form-check input { accent-color: #185FA5; }
        .form-forgot { font-size: 13px; color: #185FA5; text-decoration: none; font-weight: 500; }
        .form-forgot:hover { text-decoration: underline; }

        .btn-submit { width: 100%; padding: 11px; background: #185FA5; color: #fff; border: none; border-radius: 10px; font-size: 14px; font-weight: 600; font-family: 'Inter', sans-serif; cursor: pointer; transition: all 0.2s; display: flex; align-items: center; justify-content: center; gap: 8px; }
        .btn-submit:hover { background: #145090; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(24,95,165,0.3); }

        .card-footer { margin-top: 16px; text-align: center; padding-top: 16px; border-top: 1px solid #f1f5f9; font-size: 13px; color: #64748b; }
        .card-footer a { color: #185FA5; font-weight: 600; text-decoration: none; }
        .card-footer a:hover { text-decoration: underline; }

        .error-box { background: #fef2f2; border: 1px solid #fecaca; border-radius: 9px; padding: 11px 13px; font-size: 13px; color: #991b1b; margin-bottom: 14px; display: flex; align-items: center; gap: 8px; }
        .error-box i { font-size: 15px; flex-shrink: 0; }

        /* ── FOOTER ─────────────────────────── */
        .footer { background: #fff; border-top: 1px solid #e8edf3; padding: 16px 48px; display: flex; align-items: center; justify-content: space-between; }
        .footer-brand { font-size: 13px; font-weight: 600; color: #0f172a; }
        .footer-brand span { color: #185FA5; }
        .footer-copy { font-size: 12px; color: #94a3b8; }
    </style>
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar">
        <a href="#" class="nav-brand">
            <div class="nav-brand-icon"><i class="ti ti-search"></i></div>
            <span class="nav-brand-name">Find<span>IT</span></span>
        </a>
        <div class="nav-links">
            <a href="{{ route('register') }}" class="nav-btn">
                <i class="ti ti-user-plus" style="font-size:13px;"></i> Create Account
            </a>
        </div>
    </nav>

    <!-- MAIN -->
    <div class="main">

        <!-- Left Content -->
        <div class="left">
            <div class="hero-badge">
                <i class="ti ti-map-pin" style="font-size:12px;"></i>
                CTU – Tuburan Campus
            </div>
            <h1 class="hero-title">
                Find Lost Items.<br>
                Reunite with <span>Ease.</span>
            </h1>
            <p class="hero-sub">
                FindIT is a smart lost and found management system for CTU Tuburan Campus.
                Report items, get matched automatically, and claim your belongings — all in one place.
            </p>

            <div class="features-list">
                <div class="feature-item">
                    <div class="feature-icon" style="background:#EBF3FC;">
                        <i class="ti ti-git-compare" style="color:#185FA5;"></i>
                    </div>
                    <div class="feature-text">Smart Match Score Algorithm (Location 40% + Date 30% + Category 30%)</div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon" style="background:#EAF3DE;">
                        <i class="ti ti-map-pin" style="color:#3B6D11;"></i>
                    </div>
                    <div class="feature-text">Zone-Based Location Matching — 6 CTU Campus Zones</div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon" style="background:#FAEEDA;">
                        <i class="ti ti-bell" style="color:#854F0B;"></i>
                    </div>
                    <div class="feature-text">Instant Notifications for HIGH & POSSIBLE Matches</div>
                </div>
                <div class="feature-item">
                    <div class="feature-icon" style="background:#EEEDFE;">
                        <i class="ti ti-shield-check" style="color:#534AB7;"></i>
                    </div>
                    <div class="feature-text">Verified Claim Process with Proof of Ownership</div>
                </div>
            </div>

            <div class="hero-stats">
                <div>
                    <div class="stat-val">Smart</div>
                    <div class="stat-label">Auto Matching</div>
                </div>
                <div style="width:1px;background:#e2e8f0;"></div>
                <div>
                    <div class="stat-val">6</div>
                    <div class="stat-label">Campus Zones</div>
                </div>
                <div style="width:1px;background:#e2e8f0;"></div>
                <div>
                    <div class="stat-val">Fast</div>
                    <div class="stat-label">Claim Process</div>
                </div>
            </div>
        </div>

        <!-- Login Card -->
        <div class="login-card">
            <div class="card-header">
                <div class="card-icon"><i class="ti ti-search"></i></div>
                <div class="card-title">Welcome back!</div>
                <div class="card-sub">Sign in to your FindIT account</div>
            </div>

            @if(session('status'))
                <div style="margin-bottom:14px;padding:10px 14px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;font-size:13px;color:#166534;">
                    {{ session('status') }}
                </div>
            @endif

            @if($errors->any())
                <div class="error-box">
                    <i class="ti ti-alert-circle"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <div class="input-wrap">
                        <i class="ti ti-mail input-icon"></i>
                        <input type="email" name="email" class="form-input"
                            placeholder="Enter your email"
                            value="{{ old('email') }}" required autofocus>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="input-wrap">
                        <i class="ti ti-lock input-icon"></i>
                        <input type="password" name="password" id="password"
                            class="form-input" placeholder="Enter your password" required>
                        <button type="button" class="input-action" onclick="togglePwd()">
                            <i class="ti ti-eye" id="eye-icon"></i>
                        </button>
                    </div>
                </div>

                <div class="form-row">
                    <label class="form-check">
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                    @if(Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="form-forgot">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="btn-submit">
                    <i class="ti ti-login"></i> Sign In
                </button>
            </form>

            <div class="card-footer">
                Don't have an account?
                <a href="{{ route('register') }}">Create account →</a>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="footer-brand">Find<span>IT</span> — Lost and Found Management System</div>
        <div class="footer-copy">© {{ date('Y') }} CTU Tuburan Campus · BSIT Capstone 2025–2026</div>
    </footer>

    <script>
    function togglePwd() {
        const pwd = document.getElementById('password');
        const icon = document.getElementById('eye-icon');
        if (pwd.type === 'password') {
            pwd.type = 'text';
            icon.className = 'ti ti-eye-off';
        } else {
            pwd.type = 'password';
            icon.className = 'ti ti-eye';
        }
    }
    </script>
</body>
</html>