<?php

include "db.php";

include "base.php";

$user = $_SESSION['user'];
$search = '';
if (isset($_GET[$search])){ # Search list
    $query = $pdo -> prepare("SELECT * FROM course_project.account_data WHERE name LIKE ? OR course_name LIKE ?");
    $query -> execute("%$search%","%$search%");
    $account_data = $query -> fetchAll();
} else { # Regular list
    $query = $pdo -> query("SELECT * FROM course_project.account_data ad 
                                            JOIN course_project.courses c ON ad.course_id = c.course_id # apperantly i have to call user_id not user_name
                                            JOIN course_project.users u ON ad.user_id = u.user_id ");  # after that i can just call any column in that table
    
    $account_data = $query -> fetchAll();
}

?>

<div class="container mt-5">

    <h1 class="text-center">Home Page</h1>
    
    <hr>

    <div class="card w-100 mt-3 text-center">
        <h3>Welcome <?= $user['name'] ?></h3>
        <hr>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta ex pariatur iure quas tenetur accusantium est laudantium id expedita, autem ea porro quos officiis deleniti, cumque error neque exercitationem praesentium?</p>
    </div>

    <br>

    <div class="card w-100 mt-3">
        <h3 class="text-center">Enlisted Courses</h3>

        <hr>

        <table class="text-center w-100">
            <thead>
                <tr>
                    <th>Course Name</th>
                    <th>Course Description</th>
                    <th>User</th>
                    <th>Assigned Date</th>
                </tr>
            </thead>
        <?php foreach($account_data as $signedup_courses): ?>
        <tr>
            <td><?= $signedup_courses['course_name'] ?></td>
            <td><?= $signedup_courses['description'] ?></td>
            <td><?= $signedup_courses['name'] ?></td>
            <td><?= $signedup_courses['account_data_date'] ?></td>
        </tr>
        <?php endforeach; ?>

        </table>

    </div>

    <div class="card w-100 mt-3 text-center">
        <h3>Learn about Cyber Security and Pen testing</h3>
        <hr>
        <img class="img-fluid rounded" src="static/img/stock2.webp" alt="">
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta ex pariatur iure quas tenetur accusantium est laudantium id expedita, autem ea porro quos officiis deleniti, cumque error neque exercitationem praesentium?</p>
    </div>

    <div class="card w-100 mt-3 text-center">
        <h3>We have many courses on new and upcomming technology courses</h3>
        <hr>
        <img  class="img-fluid rounded"  src="static/img/stock1.jpg" alt="">
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta ex pariatur iure quas tenetur accusantium est laudantium id expedita, autem ea porro quos officiis deleniti, cumque error neque exercitationem praesentium?</p>
    </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>