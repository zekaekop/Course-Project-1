<?php

include "db.php";

include "base.php";

$user = $_SESSION['user'];

?>

<div class="container mt-5">
    <h1 class="text-center">Home Page</h1>
    <div class="card w-100 mt-3 text-center">
        <h3>Welcome <?= $user['name'] ?></h3>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta ex pariatur iure quas tenetur accusantium est laudantium id expedita, autem ea porro quos officiis deleniti, cumque error neque exercitationem praesentium?</p>
    </div>

    <br>

    <div class="card w-100 mt-3">
        <h3 class="text-center">Enlisted Courses</h3>

        <table>
            <thead>
                <tr>
                    <th>Course Name</th>
                    <th>Course Description</th>
                    <th>User</th>
                    <th>Assigned Date</th>
                </tr>
            </thead>
        <tr>
            <td>bla course</td>
            <td>eko</td>
            <td>today</td>
        </tr>
        </table>

    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>