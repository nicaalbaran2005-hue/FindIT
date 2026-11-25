<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FindIT — Create Account</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; min-height: 100vh; display: flex; }

        .left-panel {
            width: 420px; flex-shrink: 0;
            background: #185FA5;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            padding: 48px; position: relative; overflow: hidden;
        }
        .left-panel::before {
            content: ''; position: absolute; top: -100px; right: -100px;
            width: 300px; height: 300px;
            background: rgba(255,255,255,0.06); border-radius: 50%;
        }
        .left-panel::after {
            content: ''; position: absolute; bottom: -80px; left: -80px;
            width: 250px; height: 250px;
            background: rgba(255,255,255,0.04); border-radius: 50%;
        }
        .left-content { position: relative; z-index: 1; text-align: center; }
        .left-logo {
            width: 64px; height: 64px;
            background: rgba(255,255,255,0.15);
            border-radius: 18px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
        }
        .left-logo i { color: #fff; font-size: 32px; }
        .left-title { font-size: 28px; font-weight: 800; color: #fff; margin-bottom: 8px; letter-spacing: -0.5px; }
        .left-title span { color: #93c5fd; }
        .left-sub { font-size: 13px; color: rgba(255,255,255,0.7); line-height: 1.7; margin-bottom: 32px; }

        .left-steps { display: flex; flex-direction: column; gap: 12px; text-align: left; width: 100%; }
        .left-step {
            display: flex; align-items: center; gap: 12px;
            background: rgba(255,255,255,0.08);
            border-radius: 10px; padding: 12px 14px;
        }
        .step-num {
            width: 28px; height: 28px; border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700; color: #fff; flex-shrink: 0;
        }
        .step-text { font-size: 12.5px; color: rgba(255,255,255,0.85); font-weight: 500; }

        .left-badge {
            margin-top: 28px;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 8px; padding: 10px 16px;
            font-size: 12px; color: rgba(255,255,255,0.7);
        }
        .left-badge b { color: #fff; }

        .right-panel {
            flex: 1; background: #f8fafc;
            display: flex; align-items: center; justify-content: center;
            padding: 32px; overflow-y: auto;
        }
        .form-box {
            background: #fff; border-radius: 20px;
            border: 1px solid #e8edf3;
            padding: 36px; width: 100%; max-width: 440px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.04);
        }
        .form-header { margin-bottom: 24px; }
        .form-title { font-size: 21px; font-weight: 700; color: #0f172a; margin-bottom: 5px; }
        .form-sub { font-size: 13px; color: #64748b; }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
        .form-group { margin-bottom: 14px; }
        .form-group.full { grid-column: span 2; }
        .form-label { display: block; font-size: 12.5px; font-weight: 500; color: #374151; margin-bottom: 5px; }
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
            color: #94a3b8; font-size: 16px; pointer-events: none;
        }
        .form-input {
            width: 100%; padding: 9px 11px 9px 36px;
            border: 1.5px solid #e2e8f0; border-radius: 9px;
            font-size: 13px; color: #1e293b;
            font-family: 'Inter', sans-serif;
            background: #f8fafc; transition: all 0.15s;
        }
        .form-input:focus {
            outline: none; border-color: #185FA5;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(24,95,165,0.1);
        }
        .input-action {
            position: absolute; right: 11px; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer;
            color: #94a3b8; font-size: 16px; padding: 0;
        }
        .input-action:hover { color: #475569; }

        .btn-submit {
            width: 100%; padding: 11px;
            background: #185FA5; color: #fff;
            border: none; border-radius: 10px;
            font-size: 14px; font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer; transition: all 0.2s;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            margin-top: 6px;
        }
        .btn-submit:hover { background: #145090; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(24,95,165,0.3); }

        .form-footer { margin-top: 16px; text-align: center; font-size: 13px; color: #64748b; }
        .form-footer a { color: #185FA5; font-weight: 600; text-decoration: none; }
        .form-footer a:hover { text-decoration: underline; }

        .error-box {
            background: #fef2f2; border: 1px solid #fecaca;
            border-radius: 10px; padding: 12px 14px;
            font-size: 12.5px; color: #991b1b;
            margin-bottom: 16px;
            display: flex; align-items: flex-start; gap: 8px;
        }
        .error-box i { font-size: 15px; flex-shrink: 0; margin-top: 1px; }

        .section-divider {
            font-size: 11px; font-weight: 600; color: #94a3b8;
            text-transform: uppercase; letter-spacing: 0.06em;
            margin: 16px 0 12px;
            display: flex; align-items: center; gap: 8px;
        }
        .section-divider::before, .section-divider::after {
            content: ''; flex: 1; height: 1px; background: #f1f5f9;
        }

        @media (max-width: 768px) {
            .left-panel { display: none; }
            .form-grid { grid-template-columns: 1fr; }
            .form-group.full { grid-column: span 1; }
        }
    </style>
</head>
<body>

    <!-- Left Panel -->
    <div class="left-panel">
        <div class="left-content">
            <div class="left-logo"><i class="ti ti-search"></i></div>
            <div class="left-title">Find<span>IT</span></div>
            <div class="left-sub">
                Join the CTU Tuburan Campus<br>
                Lost and Found community.
            </div>

            <div class="left-steps">
                <div class="left-step">
                    <div class="step-num">1</div>
                    <div class="step-text">Create your account</div>
                </div>
                <div class="left-step">
                    <div class="step-num">2</div>
                    <div class="step-text">Report lost or found items</div>
                </div>
                <div class="left-step">
                    <div class="step-num">3</div>
                    <div class="step-text">Get matched automatically</div>
                </div>
                <div class="left-step">
                    <div class="step-num">4</div>
                    <div class="step-text">Claim and reunite!</div>
                </div>
            </div>

            <div class="left-badge">
                <b>CTU Tuburan Campus</b> · BSIT Capstone 2025–2026
            </div>
        </div>
    </div>

    <!-- Right Panel -->
    <div class="right-panel">
        <div class="form-box">
            <div class="form-header">
                <div class="form-title">Create your account</div>
                <div class="form-sub">Fill in your details to get started with FindIT.</div>
            </div>

            @if($errors->any())
                <div class="error-box">
                    <i class="ti ti-alert-circle"></i>
                    <div>
                        <ul style="list-style:disc;padding-left:14px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="section-divider">Personal Information</div>

                <div class="form-grid">
                    <!-- Full Name -->
                    <div class="form-group full">
                        <label class="form-label">Full Name <span style="color:#dc2626;">*</span></label>
                        <div class="input-wrap">
                            <i class="ti ti-user input-icon"></i>
                            <input type="text" name="name" class="form-input"
                                placeholder="Enter your full name"
                                value="{{ old('name') }}" required autofocus>
                        </div>
                    </div>

                    <!-- ID Number -->
                    <div class="form-group">
                        <label class="form-label">ID Number <span style="color:#dc2626;">*</span></label>
                        <div class="input-wrap">
                            <i class="ti ti-id input-icon"></i>
                            <input type="text" name="id_number" class="form-input"
                                placeholder="e.g. 2024-0001"
                                value="{{ old('id_number') }}" required>
                        </div>
                    </div>

                    <!-- Contact Number -->
                    <div class="form-group">
                        <label class="form-label">Contact Number <span style="color:#dc2626;">*</span></label>
                        <div class="input-wrap">
                            <i class="ti ti-phone input-icon"></i>
                            <input type="text" name="contact_number" class="form-input"
                                placeholder="09xxxxxxxxx"
                                value="{{ old('contact_number') }}" required>
                        </div>
                    </div>
                </div>

                <div class="section-divider">Account Details</div>

                <!-- Email -->
                <div class="form-group">
                    <label class="form-label">Email Address <span style="color:#dc2626;">*</span></label>
                    <div class="input-wrap">
                        <i class="ti ti-mail input-icon"></i>
                        <input type="email" name="email" class="form-input"
                            placeholder="Enter your email"
                            value="{{ old('email') }}" required>
                    </div>
                </div>

                <!-- Password -->
                <div class="form-group">
                    <label class="form-label">Password <span style="color:#dc2626;">*</span></label>
                    <div class="input-wrap">
                        <i class="ti ti-lock input-icon"></i>
                        <input type="password" name="password" id="pwd1"
                            class="form-input" placeholder="Min. 8 characters" required>
                        <button type="button" class="input-action" onclick="togglePwd('pwd1','eye1')">
                            <i class="ti ti-eye" id="eye1"></i>
                        </button>
                    </div>
                </div>

                <!-- Confirm Password -->
                <div class="form-group">
                    <label class="form-label">Confirm Password <span style="color:#dc2626;">*</span></label>
                    <div class="input-wrap">
                        <i class="ti ti-lock-check input-icon"></i>
                        <input type="password" name="password_confirmation" id="pwd2"
                            class="form-input" placeholder="Re-enter your password" required>
                        <button type="button" class="input-action" onclick="togglePwd('pwd2','eye2')">
                            <i class="ti ti-eye" id="eye2"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-submit">
                    <i class="ti ti-user-plus"></i> Create Account
                </button>
            </form>

            <div class="form-footer">
                Already have an account?
                <a href="{{ route('login') }}">Sign in →</a>
            </div>
            
        </div>
    </div>

    <script>
    function togglePwd(fieldId, iconId) {
        const pwd = document.getElementById(fieldId);
        const icon = document.getElementById(iconId);
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