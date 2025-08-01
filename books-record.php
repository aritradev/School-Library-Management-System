<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
}
$showAlert = false;

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['view_roll_no'])) {
    $roll_no = $_GET['view_roll_no'];
    $student_class = $_GET['student_class'];
    $id = $_GET['student_class'] . '-' . $_GET['view_roll_no'];
    $sql = "SELECT * FROM `all_students` WHERE id='$id'";
    include_once 'dbCon.php';
    $result = mysqli_query($con, $sql);
    $rowNos = mysqli_num_rows($result);
    $row = mysqli_fetch_assoc($result);
    $student_name = $row['name'];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['issue_roll_no'])) {
    $roll_no = $_POST['issue_roll_no'];
    $student_class = $_POST['student_class'];
    $student_name = $_POST['student_name'];
    $book_name = $_POST['book_name'];
    $issue_date = $_POST['issue_date'];
    $remark = $_POST['remark'];
    $id = $student_class . '-' . $roll_no;
    include_once 'dbCon.php';
    $sql = "INSERT INTO `books_record` VALUES (NULL,'$student_name','$id','$student_class','$roll_no','$book_name','$issue_date','NO','','$remark');"; //NULL for auto inrement
    $result = mysqli_query($con, $sql);
    if ($result) {
        $showAlert = true;
        $alertClass = 'alert-success';
        $alertMsg = "$book_name issued to $student_name($student_class-$roll_no)";
    } else {
        $showAlert = true;
        $alertClass = 'alert-danger';
        $alertMsg = "Error, $book_name not issued to $student_name($student_class-$roll_no)";
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];

    $sql = "SELECT * FROM `books_record` WHERE id=$edit_id";
    include_once 'dbCon.php';
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $student_name = $row['student_name'];
    $student_class = $row['class'];
    $roll_no = $row['roll_no'];

    $book_name = $_POST['book_name'];
    $issue_date = $_POST['issue_date'];
    $returned = $_POST['returned'];
    $return_date = $_POST['return_date'];
    $remark = $_POST['remark'];
    if ($returned == 'NO') {
        $return_date = '';
    }
    $sql = "UPDATE `books_record` SET `book_name`='$book_name',`issued_on`='$issue_date',`returned`='$returned',`returned_on`='$return_date',`remark`='$remark'  WHERE `id`='$edit_id'";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $showAlert = true;
        $alertClass = 'alert-success';
        $alertMsg = "Record no $edit_id updated";
    } else {
        $showAlert = true;
        $alertClass = 'alert-danger';
        $alertMsg = "Error, Record no $edit_id not updated";
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    include_once 'dbCon.php';

    $sql = "SELECT * FROM `books_record` WHERE id=$delete_id";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $roll_no = $row['roll_no'];
    $student_class = $row['class'];
    $student_name = $row['student_name'];

    $sql = "DELETE FROM `books_record` WHERE `id`=$delete_id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $showAlert = true;
        $alertClass = 'alert-success';
        $alertMsg = "Record no $delete_id deleted";
    } else {
        $showAlert = true;
        $alertClass = 'alert-danger';
        $alertMsg = "Error, Record no $delete_id not deleted";
    }
}
?>
<!doctype html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <!-- Bootstrap CSS -->
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <title>Books Record</title>
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

        .info-card,
        .table-card {
            background: #fff;
            border-radius: 1.2rem;
            box-shadow: 0 4px 24px rgba(44, 62, 80, 0.10);
            padding: 2rem 2rem 1.5rem 2rem;
            max-width: 1000px;
            margin: 0 auto 1.5rem auto;
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

        .btn-danger {
            background: linear-gradient(90deg, #e96443 0%, #904e95 100%);
            border: none;
            font-weight: 500;
        }

        .btn-danger:hover {
            background: linear-gradient(90deg, #904e95 0%, #e96443 100%);
        }

        .alert {
            border-radius: 0.7rem;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            background: #e0eafc;
            color: #457fca !important;
            border-radius: 0.3rem;
            margin: 0 2px;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #457fca !important;
            color: #fff !important;
        }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 0.4rem;
            border: 1px solid #cfdef3;
        }

        .modal-content {
            border-radius: 1.2rem;
            box-shadow: 0 4px 24px rgba(44, 62, 80, 0.13);
        }

        @media (max-width: 575.98px) {
            .info-card,
            .table-card {
                padding: 1.2rem 0.3rem 1.2rem 0.3rem;
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
        <div class="mb-3 d-flex flex-wrap gap-2 align-items-center">
            <a href="home.php" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Home
            </a>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_trans">
                <i class="bi bi-plus-circle"></i> Issue New Book
            </button>
            <a href="home.php?delete_roll_no=<?php echo $roll_no ?>&student_class=<?php echo $student_class ?>&name=<?php echo $student_name ?>" class="btn btn-danger ms-auto" onclick="return confirm('Sure to delete <?php echo $student_name ?>?')">
                <i class="bi bi-trash"></i> Delete Student
            </a>
        </div>
        <div class="info-card mb-3">
            <h4 class="main-title mb-2">Student Information</h4>
            <div class="fs-5"><b>Name:</b> <?php echo $student_name ?><br><b>Class:</b> <?php echo $student_class ?><br><b>Roll no:</b> <?php echo $roll_no ?></div>
        </div>
        <div class="table-card">
            <h4 class="main-title mb-3 text-center">Book Records</h4>
            <div class="table-responsive">
                <table id="view_cust" class="table table-striped table-bordered align-middle" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>Record no</th>
                            <th>Name of Book</th>
                            <th>Issue Date</th>
                            <th>Returned</th>
                            <th>Return Date</th>
                            <th>Remark</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM `books_record` WHERE `class`='$student_class' AND roll_no='$roll_no' ORDER BY returned DESC";
                        $result = mysqli_query($con, $sql);
                        $rowNos = mysqli_num_rows($result);
                        for ($x = 0; $x < $rowNos; $x++) {
                            $row = mysqli_fetch_assoc($result);
                            $id = $row['id'];
                            $book_name = $row['book_name'];
                            $issued_on = $row['issued_on'];
                            $returned = $row['returned'];
                            $returned_on = $row['returned_on'];
                            $remark = $row['remark'];
                            echo "<tr>
                                <td>$id</td>
                                <td>$book_name</td>
                                <td>$issued_on</td>
                                <td>$returned</td>
                                <td>$returned_on</td>
                                <td>$remark</td>
                                <td>
                                    <a href='record-edit.php?edit_id=$id' class='btn btn-primary btn-sm'>Edit</a>
                                    <a href='books-record.php?delete_id=$id' class='btn btn-danger btn-sm' onclick=\"return confirm('Sure to delete Record no $id?')\">Delete</a>
                                </td>
                            </tr>";
                        }
                        mysqli_close($con);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="add_trans" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light border-0">
                        <h5 class="modal-title" id="exampleModalLabel">Issue New Book to <?php echo "$student_name ($id)" ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="books-record.php" method="POST">
                            <input type="text" class="form-control d-none" name="student_class" id="student_class" value='<?php echo "$student_class" ?>'>
                            <input type="text" class="form-control d-none" name="issue_roll_no" id="issue_roll_no" value='<?php echo "$roll_no" ?>'>
                            <input type="text" class="form-control d-none" name="student_name" id="student_name" value='<?php echo "$student_name" ?>'>
                            <div class="mb-2">
                                <label for="book_name" class="form-label">Book Name</label>
                                <input class="form-control" type="text" name="book_name" id="book_name" required>
                            </div>
                            <div class="mb-2">
                                <label for="issue_date" class="form-label">Issue Date</label>
                                <input class="form-control" value="<?php echo date('Y-m-d'); ?>" type="date" name="issue_date" id="issue_date" required>
                            </div>
                            <div class="mb-2">
                                <label for="remark" class="form-label">Remark</label>
                                <input class="form-control" type="text" name="remark" id="remark" placeholder="Enter remark if any">
                            </div>
                            <button type="submit" class="btn btn-primary w-100 mt-2">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
    <script>
        $(document).ready(function() {
            $('#view_cust').DataTable({
                "scrollX": true,
                "pageLength": 10,
            });
        });
    </script>
</body>

</html>