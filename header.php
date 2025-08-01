<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top" style="background: linear-gradient(90deg, #232526 0%, #414345 100%);">
    <div class="container-fluid">
        <a class="navbar-brand text-danger fw-bold d-flex align-items-center" href="home.php">
            <img src="images/user.png" alt="Library" width="32" height="32" class="d-inline-block align-text-top me-2">
            <span style="font-family: 'Roboto', Arial, sans-serif;">Library</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="issue-return-books.php">Issue/Return</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="all-issued-books.php">All Issued</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="all-students.php">All Students</a>
                </li>
            </ul>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <span class="text-white small d-none d-md-inline" style="font-family: 'Roboto', Arial, sans-serif;">
                    <?php if(isset($_SESSION['username'])) echo '<i class="bi bi-person-circle"></i> '.htmlspecialchars($_SESSION['username']); ?>
                </span>
                <div class="btn-group">
                    <button type="button" class="btn btn-danger dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person"></i> User
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end animate__animated animate__fadeInDown">
                        <li><a class="dropdown-item" href="change-password.php">Change Password</a></li>
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<style>
    .navbar-nav .nav-link {
        padding: 0.5em 1em;
        font-weight: 500;
        transition: color 0.2s, background 0.2s;
        border-radius: 0.4em;
    }
    .navbar-nav .nav-link.active, .navbar-nav .nav-link:hover {
        color: #ffc107 !important;
        background: rgba(255,255,255,0.05);
    }
    .btn-group .btn-danger {
        min-width: 90px;
        border-radius: 0.5em;
    }
    .dropdown-menu {
        border-radius: 0.7em;
        min-width: 160px;
        box-shadow: 0 4px 24px rgba(44, 62, 80, 0.13);
    }
    .dropdown-item:active, .dropdown-item:hover {
        background: #457fca;
        color: #fff;
    }
    @media (max-width: 991.98px) {
        .navbar-nav .nav-link {
            padding: 0.5em 0.8em;
        }
        .navbar-brand img {
            width: 28px;
            height: 28px;
        }
    }
    @media (max-width: 575.98px) {
        .navbar-brand span {
            font-size: 1.1rem;
        }
    }
</style>

<?php
// $username = $_SESSION['username'];
// echo "<script>
//     document.getElementById('userMenu').innerHTML='$username';
//   </script>";
?>