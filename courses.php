<?php

include "db.php";

include "base.php";

$user = $_SESSION['user'];

$search = '';

# if search isnt emty than do a filter on the table and get results, else just get all data from the table
if (isset($_GET['search'])){
    $search =   trim($_GET['search']);
    $query = $pdo -> prepare("SELECT * FROM courses WHERE 
                                                course_name LIKE ? OR 
                                                description LIKE ? OR 
                                                category LIKE ? OR 
                                                teacher LIKE ? OR 
                                                price LIKE ? OR 
                                                starting_date LIKE ?");
    
    $query -> execute(["%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%"]);
    $courses = $query -> fetchAll();
} else {
    $query = $pdo -> query("SELECT * FROM course_project.courses co 
                                            JOIN course_project.categories ca ON co.category = ca.category_id 
                                            JOIN course_project.teachers t ON co.teacher = t.teacher_id ");
    $courses = $query -> fetchAll();
}
?>

<div class="container mt-5">
    <h1 class="text-center">Current Courses</h1>

        <div class="card w-100 mt-3 text-center">
            <h3>Welcome <?= $user['name'] ?></h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta ex pariatur iure quas tenetur accusantium est laudantium id expedita, autem ea porro quos officiis deleniti, cumque error neque exercitationem praesentium?</p>
        </div>

        <br>

        <?php include('search.php'); ?>

        <br>

        <div class="card w-100 mt-3">
            <h3 class="text-center">Available Courses</h3>

            <table class="text-center w-100">
                <thead>
                    <tr>
                        <th>Course</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Teacher</th>
                        <th>Price</th>
                        <th>Starting Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
            <?php foreach($courses as $course): ?>
                <tr>
                    <td><?= $course['course_name'] ?></td>
                    <td><?= $course['description'] ?></td>
                    <td><?= $course['category_name'] ?></td>
                    <td><?= $course['teacher_name'] ?></td>
                    <td><?= $course['price'] ?></td>
                    <td><?= $course['starting_date'] ?></td>
                    <td><button class="btn btn-primary p-0" style="border-radius: 0.5rem;">Sign Up</button></td>
                </tr>
            <?php endforeach ?>
            </table>

        </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>