<?php

include "db.php";

?>

<div class="nav navbar ">
    <div class="d-flex justify-content-center w-100">

        <form method="POST" action="">
            <div class="card">

                <nav>
                    <ul class="nav">
                        <li class="nav-item"><a href="courses.php" class="nav-link text-black">Courses</a></li>
                        <li class="nav-item"><a href="categories.php" class="nav-link text-black">Category</a></li>
                        
                        <?php if (True): ?>
                            <li class="nav-item">
                                <a href="admin.php" class="nav-link text-black">Admin Panel</a>
                            </li>
                        <?php endif; ?>

                        <li class="nav-item"><a href="logout.php" class="nav-link text-black">Logout</a></li>

                    </ul>
                </nav>

            </div>
        </form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>