<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
}
$showAlert = false;
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
    <title>All Issued Books</title>
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

        .table-card {
            background: #fff;
            border-radius: 1.2rem;
            box-shadow: 0 4px 24px rgba(44, 62, 80, 0.10);
            padding: 2.5rem 2rem 2rem 2rem;
            max-width: 1100px;
            margin: 0 auto;
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

        @media (max-width: 575.98px) {
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
        <div class="mb-3">
            <a href="home.php" class="back-btn btn mb-2">
                <i class="bi bi-arrow-left"></i> Home
            </a>
        </div>
        <div class="table-card mt-2">
            <h3 class="main-title mb-3 text-center">All Issued Books</h3>
            <div class="table-responsive">
                <table id="view_cust" class="table table-striped table-bordered align-middle" style="width:100%">
                    <thead class="table-light">
                        <tr>
                            <th>SN</th>
                            <th>Book Name</th>
                            <th>Issued to</th>
                            <th>Class</th>
                            <th>Roll no</th>
                            <th style='min-width:80px'>Issued Date</th>
                            <th>Remark</th>
                            <th>Record</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM `books_record` WHERE returned='NO' ORDER BY class ASC";
                        include_once 'dbCon.php';
                        $result = mysqli_query($con, $sql);
                        $rowNos = mysqli_num_rows($result);
                        for ($x = 0; $x < $rowNos; $x++) {
                            $sn = $x + 1;
                            $row = mysqli_fetch_assoc($result);
                            $student_name = $row['student_name'];
                            $class = $row['class'];
                            $roll_no = $row['roll_no'];
                            $book_name = $row['book_name'];
                            $issued_on = $row['issued_on'];
                            $remark = $row['remark'];
                            echo "<tr>
                                <td>$sn</td>
                                <td>$book_name</td>
                                <td>$student_name</td>
                                <td>$class</td>
                                <td>$roll_no</td>
                                <td>$issued_on</td>
                                <td>$remark</td>
                                <td>
                                    <a href='books-record.php?student_class=$class&view_roll_no=$roll_no' class='btn btn-primary btn-sm'>View</a>
                                </td>
                            </tr>";
                        }
                        mysqli_close($con);
                        ?>
                    </tbody>
                </table>
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