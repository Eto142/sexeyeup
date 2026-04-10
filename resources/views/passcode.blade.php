<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Passcode — SexEyeUp</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/app.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            background: var(--bg-body);
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .passcode-wrap {
            width: 100%;
            max-width: 400px;
            padding: 1.5rem;
        }

        .passcode-card {
            background: var(--bg-card);
            border: 1px solid var(--border-main);
            border-radius: 16px;
            padding: 2.5rem 2rem;
            text-align: center;
            box-shadow: 0 8px 40px rgba(0,0,0,.45);
        }

        .passcode-icon {
            font-size: 2.8rem;
            margin-bottom: .75rem;
        }

        .passcode-title {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2rem;
            letter-spacing: .04em;
            color: var(--green-neon);
            margin-bottom: .4rem;
        }

        .passcode-sub {
            font-size: .88rem;
            color: var(--text-muted-c);
            margin-bottom: 1.75rem;
            line-height: 1.6;
        }

        .passcode-input {
            width: 100%;
            background: var(--bg-card2);
            border: 1px solid var(--border-main);
            border-radius: 10px;
            color: var(--text-white);
            font-size: 1.1rem;
            letter-spacing: .2em;
            text-align: center;
            padding: .75rem 1rem;
            outline: none;
            transition: border-color .2s;
        }
        .passcode-input:focus {
            border-color: var(--green-bright);
            box-shadow: 0 0 0 3px rgba(118,212,77,.15);
        }
        .passcode-input::placeholder {
            letter-spacing: .05em;
            color: var(--text-muted-c);
        }

        .btn-enter {
            width: 100%;
            margin-top: 1rem;
            background: linear-gradient(135deg, var(--green-main), var(--green-bright));
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: .75rem;
            font-weight: 700;
            font-size: 1rem;
            letter-spacing: .05em;
            cursor: pointer;
            transition: opacity .2s;
        }
        .btn-enter:hover { opacity: .88; }

        .error-msg {
            background: rgba(239,68,68,.12);
            border: 1px solid rgba(239,68,68,.3);
            color: #f87171;
            border-radius: 8px;
            padding: .6rem .9rem;
            font-size: .83rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="passcode-wrap">
        <div class="passcode-card">
            <div class="passcode-icon">🔒</div>
            <div class="passcode-title">Private Access</div>
            <p class="passcode-sub">This site is password protected.<br>Enter the passcode to continue.</p>

            @if($errors->has('passcode'))
                <div class="error-msg">{{ $errors->first('passcode') }}</div>
            @endif

            <form method="POST" action="{{ route('passcode.verify') }}">
                @csrf
                <input
                    type="password"
                    name="passcode"
                    class="passcode-input"
                    placeholder="Enter passcode"
                    autofocus
                    autocomplete="off"
                >
                <button type="submit" class="btn-enter">Unlock Site</button>
            </form>
        </div>
    </div>
</body>
</html>
