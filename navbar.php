<?php

include "db.php";

# If user isnt logged in, they cant see the website
if(!isset ($_SESSION['user'])){
    header("location: login.php");
    exit;
}

$user = $_SESSION['user'];

?>

<div class="container">
    <div class="nav navbar pt-0">
        <div class="w-100">

            <form method="POST" action="">
                <div class="card  header-custom w-100">

                    <nav class="d-flex">
                        <ul class="nav w-100">
                            <li class="nav-item"><a href="home.php" class="nav-link text-selected">Home</a></li>
                            <li class="nav-item"><a href="courses.php" class="nav-link text-selected">Courses</a></li>
                            <li class="nav-item"><a href="categories.php" class="nav-link text-selected">Categories</a></li>
                            <li class="nav-item"><a href="teachers.php" class="nav-link text-selected">Teachers</a></li>

                            <?php if ($user['role'] == "admin"): ?>
                                <li class="nav-item">
                                    <a href="admin.php" class="nav-link text-selected">Admin Panel</a>
                                </li>
                            <?php endif; ?>

                            <li class="nav-item ms-auto"><span class="nav-link text-white"><?= $user['role'] ?></span></li>

                            <li class="nav-item mt-lg-0 ms-lg-auto">
                                
                                <a href="logout.php" class="nav-link text-selected w-100 w-lg-auto">
                                    Logout
                                </a>
                            </li>
                            
                        </ul>
                    </nav>

                </div>
            </form>

        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>