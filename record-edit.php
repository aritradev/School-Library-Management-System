<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header('Location: index.php');
}
$showAlert = false;
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    include_once 'dbCon.php';
    $sql = "SELECT * FROM `books_record` WHERE id=$edit_id";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    $student_name = $row['student_name'];
    $roll_no = $row['roll_no'];
    $class = $row['class'];
    $book_name = $row['book_name'];
    $issue_date = $row['issued_on'];
    $returned = $row['returned'];
    // echo $returned;
    $return_date = $row['returned_on'];
    $remark = $row['remark'];
}
?>
<!doctype html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <title>Record Edit</title>
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
            <?php
            echo "<a href='books-record.php?student_class=$class&view_roll_no=$roll_no' class='back-btn btn mb-2'>";
            ?>
            <i class="bi bi-arrow-left"></i> Back</a>
        </div>
        <div class="form-card mt-2">
            <h4 class="main-title mb-4 text-center">Edit Record #<?php echo "$edit_id" ?> for <?php echo "$student_name
                ($class-$roll_no)" ?></h4>
            <form action="books-record.php" method="POST">
                <input type="number" class="form-control d-none" name="edit_id" id="edit_id" value='<?php echo "$edit_id" ?>'>
                <div class="mb-3">
                    <label for="book_name" class="form-label">Book Name</label>
                    <input class="form-control" type="text" name="book_name" id="book_name" value='<?php echo "$book_name" ?>' required>
                </div>
                <div class="mb-3">
                    <label for="issue_date" class="form-label">Issue Date</label>
                    <input class="form-control" type="date" name="issue_date" id="issue_date" value='<?php echo "$issue_date" ?>' required>
                </div>
                <div class="mb-3">
                    <label for="returned" class="form-label">Returned</label>
                    <select class="form-select" name="returned" id="returned_book">
                        <option value="YES">YES</option>
                        <option value="NO">NO</option>
                    </select>
                    <script>
                        <?php echo "document.getElementById('returned_book').value = '$returned'" ?>
                    </script>
                </div>
                <div class="mb-3">
                    <label for="return_date" class="form-label">Return Date</label>
                    <input class="form-control" type="date" name="return_date" id="return_date" value='<?php echo "$return_date" ?>'>
                </div>
                <div class="mb-4">
                    <label for="remark" class="form-label">Remark</label>
                    <input class="form-control" type="text" name="remark" id="remark" value='<?php echo "$remark" ?>'>
                </div>
                <button type="submit" class="btn btn-primary w-100">Save Changes</button>
            </form>
        </div>
    </div>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js'></script>
</body>

</html>