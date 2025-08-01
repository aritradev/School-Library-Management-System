<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
}
$alertMsg = '';
$alertClass = '';
if (isset($_POST['pwd1'])) {
    $pwd1 = trim($_POST['pwd1']);
    $pwd2 = trim($_POST['pwd2']);
    date_default_timezone_set('Asia/Kolkata');
    $curr_date = date('Y-m-d H:i:s');
    if (($pwd1 != $pwd2) || $pwd1 == "") {
        $alertMsg = 'Both passwords must match and not be empty.';
        $alertClass = 'alert-danger';
    } else {
        $userFile = __DIR__ . "/data/user.json";
        if (file_exists($userFile)) {
            $user = file_get_contents($userFile);
            $user = json_decode($user, true);
            $user["password"] = $pwd1;
            file_put_contents($userFile, json_encode($user));
            session_destroy();
            $alertMsg = 'Password changed successfully! Please log in again.';
            $alertClass = 'alert-success';
        } else {
            $alertMsg = 'User file not found!';
            $alertClass = 'alert-danger';
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <title>Change Password</title>
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
            font-family: 'Roboto', Arial, sans-serif;
        }

        .form-card {
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

        .btn-primary {
            background: linear-gradient(90deg, #457fca 0%, #5691c8 100%);
            border: none;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #5691c8 0%, #457fca 100%);
        }

        .alert {
            border-radius: 0.7rem;
        }

        @media (max-width: 575.98px) {
            .form-card {
                padding: 1.5rem 0.7rem 1.2rem 0.7rem;
            }

            .main-title {
                font-size: 1.3rem;
            }
        }
    </style>
</head>

<body>
    <?php include "header.php"; ?>
    <div class="container py-4">
        <div class="form-card mt-5">
            <h3 class="main-title mb-3 text-center">Change Password</h3>
            <?php if ($alertMsg) {
                echo "<div class='alert $alertClass alert-dismissible fade show py-2 mb-3 text-center' role='alert'>
                        <strong>$alertMsg</strong>
                        <button type='button' class='btn-close pb-2' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
            } ?>
            <form method="POST" action="change-password.php">
                <div class="mb-3">
                    <label for="pwd1" class="form-label">New Password</label>
                    <input required placeholder="Enter new password" type="password" class="form-control" id="pwd1"
                        name="pwd1">
                </div>
                <div class="mb-3">
                    <label for="pwd2" class="form-label">Confirm New Password</label>
                    <input required placeholder="Enter new password again" type="password" class="form-control" id="pwd2"
                        name="pwd2">
                </div>
                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </form>
        </div>
    </div>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
</body>

</html>