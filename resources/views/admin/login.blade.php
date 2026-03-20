<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .login-card {
            border-radius: 10px;
            border: none;
        }
        .login-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #eee;
            padding: 1.5rem;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .login-body {
            padding: 2rem;
        }
        @media (max-width: 576px) {
            .login-card {
                margin: 0 15px;
            }
            .login-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body class="d-flex align-items-center min-vh-100 py-4">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7 col-sm-9">
                <div class="card login-card shadow">
                    <div class="login-header text-center">
                        <h3 class="mb-0">Admin Login</h3>
                    </div>
                    <div class="card-body login-body">
                        {{-- @if($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif --}}

                        <form method="POST" action="{{ route('admin.login.post') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Admin Email</label>
                                <input type="email" name="email" id="email" class="form-control form-control-lg" placeholder="admin@example.com" required>
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="••••••••" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>