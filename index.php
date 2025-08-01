<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    header('Location: home.php');
}
$showAlert = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['password'])) {
    $pwd = $_POST['password'];
    $user_name = $_POST['username'];
    include_once 'dbCon.php';
    $sql = "SELECT * FROM `admin` WHERE `username`='$user_name' AND `password`='$pwd'";
    $result = mysqli_query($con, $sql);
    $rowNos = mysqli_num_rows($result);
    if ($rowNos == 1) {
        $_SESSION['loggedin'] = true;
        header('Location: home.php');
    } else {
        $showAlert = true;
        $alertClass = 'alert-danger';
        $alertMsg = "Error, wrong credentials";
    }
}
?>
<!doctype html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <title>Login</title>
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
            font-family: 'Roboto', Arial, sans-serif;
        }

        .login-card {
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

        .login-img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            margin-bottom: 1rem;
        }

        @media (max-width: 575.98px) {
            .login-card {
                padding: 1.5rem 0.7rem 1.2rem 0.7rem;
            }

            .main-title {
                font-size: 1.3rem;
            }
        }
    </style>
</head>

<body>
    <?php
    if ($showAlert) {
        echo "<div class='alert $alertClass alert-dismissible fade show py-2 mb-0 text-center' role='alert'>
                <strong >$alertMsg</strong>
                <button type='button' class='btn-close pb-2' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    }
    ?>
    <div class="container d-flex align-items-center justify-content-center" style="min-height: 100vh;">
        <div class="login-card w-100 mt-5">
            <div class="text-center">
                <h3 class="main-title mb-2">Login to Library</h3>
                <img src="images/user.png" alt="User login" class="login-img">
            </div>
            <form action="index.php" method="POST">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" name="username" id="username" class="form-control" placeholder="Enter username"
                        required autocomplete="username">
                </div>
                <div class="mb-4">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter password"
                        required autocomplete="current-password">
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </div>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
</body>

</html>