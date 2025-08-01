<?php
session_start();
session_destroy();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Logging Out...</title>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
            font-family: 'Roboto', Arial, sans-serif;
        }
        .logout-card {
            background: #fff;
            border-radius: 1.2rem;
            box-shadow: 0 4px 24px rgba(44, 62, 80, 0.10);
            padding: 2.5rem 2rem 2rem 2rem;
            max-width: 400px;
            margin: 0 auto;
        }
        .main-title {
            font-weight: 700;
            color: #2b2d42;
            letter-spacing: 1px;
        }
        .spinner-border {
            color: #457fca;
        }
    </style>
    <meta http-equiv="refresh" content="2;url=index.php">
</head>
<body>
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="logout-card w-100 mt-5 text-center">
            <div class="mb-3">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Logging out...</span>
                </div>
            </div>
            <h3 class="main-title mb-2">Logging you out...</h3>
            <div class="text-muted">You will be redirected to the login page shortly.</div>
        </div>
    </div>
    <script>
        setTimeout(function() {
            window.location.href = 'index.php';
        }, 2000);
    </script>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
</body>
</html>
