<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
}
$showAlert = false;
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['view_roll_no'])) {
    $student_class = $_GET['student_class'];
    $roll_no = $_GET['view_roll_no'];
    $sql = "SELECT * FROM `all_students` WHERE class='$student_class' AND roll_no='$roll_no'";
    include_once 'dbCon.php';
    $result = mysqli_query($con, $sql);
    $rowNos = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);
    if ($rowNos == 0) {
        $showAlert = true;
        $alertClass = 'alert-danger';
        $alertMsg = "Error, No student in Class $student_class with Roll no $roll_no";
    } else {
        header("Location: books-record.php?student_class=$student_class&view_roll_no=$roll_no");
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
    <title>Issue/Return Books</title>
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

        .back-btn {
            background: #e9ecef;
            color: #457fca;
            border: none;
            font-weight: 500;
            border-radius: 0.5rem;
            transition: background 0.2s, color 0.2s;
        }

        .back-btn:hover {
            background: #d0d7de;
            color: #2b2d42;
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
    <?php
    include 'header.php';
    if ($showAlert) {
        echo "<div class='alert $alertClass alert-dismissible fade show py-2 mb-0 text-center' role='alert'>
                <strong >$alertMsg</strong>
                <button type='button' class='btn-close pb-2' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>";
    }
    ?>
    <div class="container py-4">
        <div class="mb-3">
            <a href="home.php" class="back-btn btn mb-2">
                <i class="bi bi-arrow-left"></i> Home
            </a>
        </div>
        <div class="form-card mt-2">
            <h3 class="main-title mb-3 text-center">Issue/Return Book</h3>
            <form action="issue-return-books.php" method="GET">
                <div class="mb-3">
                    <label for="student_class" class="form-label">Class</label>
                    <input type="text" class="form-control" name="student_class" id="student_class" required
                        autocomplete="off">
                </div>
                <div class="mb-3">
                    <label for="view_roll_no" class="form-label">Roll No</label>
                    <input type="text" class="form-control" name="view_roll_no" id="view_roll_no" required
                        autocomplete="off">
                </div>
                <button type="submit" class="btn btn-primary w-100">Submit</button>
            </form>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
</body>

</html>