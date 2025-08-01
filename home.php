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
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['delete_roll_no'])) {
    $delete_roll_no = $_GET['delete_roll_no'];
    $student_class = $_GET['student_class'];
    $name = $_GET['name'];
    include_once 'dbCon.php';
    $sql = "DELETE FROM `all_students` WHERE `class`=$student_class AND roll_no=$delete_roll_no";
    $result1 = mysqli_query($con, $sql);
    $sql = "DELETE FROM `books_record` WHERE `class`=$student_class AND roll_no=$delete_roll_no";
    $result2 = mysqli_query($con, $sql);
    if ($result1 && $result2) {
        $showAlert = true;
        $alertClass = 'alert-success';
        $alertMsg = "$name deleted from database";
    } else {
        $showAlert = true;
        $alertClass = 'alert-danger';
        $alertMsg = "Error, $name not deleted from database";
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
    <title>Home</title>
    <style>
        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #e0eafc 0%, #cfdef3 100%);
            font-family: 'Roboto', Arial, sans-serif;
        }

        .main-title {
            font-weight: 700;
            color: #2b2d42;
            letter-spacing: 1px;
        }

        .subtitle {
            color: #495057;
            font-size: 1.15rem;
            margin-bottom: 2rem;
        }

        .card {
            transition: transform 0.3s, box-shadow 0.3s, border 0.2s;
            min-height: 370px;
            border-radius: 1.2rem;
            box-shadow: 0 2px 12px rgba(44, 62, 80, 0.07);
            background: #fff;
            opacity: 0;
            animation: fadeInUp 0.8s forwards;
            border: 1.5px solid #e0eafc;
        }

        .card:focus-within,
        .card:active {
            border: 2px solid #457fca;
        }

        .card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .card:hover {
            transform: translateY(-10px) scale(1.04);
            box-shadow: 0 8px 32px rgba(44, 62, 80, 0.13);
            border: 2px solid #457fca;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .card-img-top {
            max-height: 120px;
            object-fit: contain;
            margin-bottom: 10px;
            border-radius: 0.7rem;
        }

        .modal-content {
            border-radius: 1.2rem;
            box-shadow: 0 4px 24px rgba(44, 62, 80, 0.13);
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, .18);
        }

        .btn-primary {
            background: linear-gradient(90deg, #457fca 0%, #5691c8 100%);
            border: none;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: background 0.2s, box-shadow 0.2s;
            box-shadow: 0 2px 8px rgba(44, 62, 80, 0.07);
        }

        .btn-primary:focus,
        .btn-primary:active {
            box-shadow: 0 0 0 0.2rem rgba(69, 127, 202, .18);
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #5691c8 0%, #457fca 100%);
        }

        .alert {
            border-radius: 0.7rem;
        }

        @media (max-width: 991.98px) {
            .row.g-4> [class^='col-'] {
                min-width: 320px;
            }
        }

        @media (max-width: 767.98px) {
            .card {
                min-height: 320px;
            }

            .main-title {
                font-size: 1.6rem;
            }
        }

        @media (max-width: 575.98px) {
            .main-title {
                font-size: 1.2rem;
            }

            .subtitle {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    <?php include 'header.php'; ?>
    <div class="container py-4">
        <?php if ($showAlert) {
            echo "<div class='alert $alertClass alert-dismissible fade show py-2 mb-3' role='alert'>
                    <strong >$alertMsg</strong>
                    <button type='button' class='btn-close pb-2' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>";
        } ?>
        <div class="text-center mb-4">
            <h1 class="main-title">Welcome to the Library Management System</h1>
            <div class="subtitle">Manage students and books efficiently. Select an option below to get started.</div>
        </div>
        <div class="row g-4 justify-content-center">
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex">
                <div class="card w-100 shadow-sm" tabindex="0">
                    <div class="card-body text-center d-flex flex-column">
                        <h5 class="card-title mb-2">Issue/Return Book</h5>
                        <img src="images/issue-return.jpg" class="card-img-top mx-auto" alt="Issue or Return Book">
                        <p class="card-text text-center mt-2 flex-grow-1">Issue/Return a book</p>
                        <button type="button" class="btn btn-primary mt-auto w-100" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Issue/Return Book
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex">
                <div class="card w-100 shadow-sm" tabindex="0">
                    <div class="card-body text-center d-flex flex-column">
                        <h5 class="card-title mb-2">All Issued Books</h5>
                        <img src="images/books.webp" class="card-img-top mx-auto" alt="All Issued Books">
                        <p class="card-text text-center mt-2 flex-grow-1">View all issued books</p>
                        <a href="all-issued-books.php" class="btn btn-primary mt-auto w-100">All Issued Books</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 d-flex">
                <div class="card w-100 shadow-sm" tabindex="0">
                    <div class="card-body text-center d-flex flex-column">
                        <h5 class="card-title mb-2">All Students</h5>
                        <img src="images/all-students.jpg" class="card-img-top mx-auto" alt="All Students">
                        <p class="card-text text-center mt-2 flex-grow-1">View all students in database</p>
                        <a href="all-students.php" class="btn btn-primary mt-auto w-100">All Students</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light border-0">
                        <h5 class="modal-title" id="exampleModalLabel">Enter Student's Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="home.php" method="GET">
                            <div class="mb-3">
                                <label for="student_class" class="form-label">Class</label>
                                <input type="text" class="form-control" name="student_class" id="student_class" required autocomplete="off">
                            </div>
                            <div class="mb-3">
                                <label for="view_roll_no" class="form-label">Roll No</label>
                                <input type="text" class="form-control" name="view_roll_no" id="view_roll_no" required autocomplete="off">
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
</body>

</html>