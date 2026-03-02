<?php
session_start();
include "db.php";

include "base.php";

?>

<div class="mt-5">
    <h1 class="text-center">Login</h1>
    <h5  class="text-center">into an existing account</h5>

    <div class="nav navbar ">
        <div class="d-flex justify-content-center">
            <form action="post">
                <div class="card">
                    
                    <ul class="p-0">
                        <li><a href="">Courses</a></li>
                        <li><a href="">Category</a></li>
                        <li><a href="">Users</a></li>

                        <li><a href="">Admin Panel</a></li>

                        <li><a href="">User</a></li> <!-- make it display the users role on the header -->

                    </ul>

                </div>
            </form>
        </div>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>