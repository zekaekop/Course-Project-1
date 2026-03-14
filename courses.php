<?php

include "db.php";

include "base.php";

$user = $_SESSION['user'];

$search = '';

# if search isnt emty than do a filter on the table and get results, else just get all data from the table
if (isset($_GET['search'])){
    $search =   trim($_GET['search']);
    $query = $pdo->prepare("SELECT * FROM course_project.courses co
                            JOIN course_project.categories ca ON co.category = ca.category_id 
                            JOIN course_project.teachers t ON co.teacher = t.teacher_id 
                            WHERE 
                            co.course_name LIKE ? OR 
                            co.description LIKE ? OR 
                            ca.category_name LIKE ? OR
                            t.teacher_name LIKE ? OR
                            co.price LIKE ? OR 
                            co.starting_date LIKE ?");
    
    $query -> execute(["%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%"]);
    $courses = $query -> fetchAll();
} else {
    $query = $pdo -> query("SELECT * FROM course_project.courses co 
                                            JOIN course_project.categories ca ON co.category = ca.category_id 
                                            JOIN course_project.teachers t ON co.teacher = t.teacher_id ");
    $courses = $query -> fetchAll();
}

# enlisting into a course
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // check if user is logged in
    if (!isset($_SESSION['user'])) {
        header("Location: login.php");
        exit();
    }
    
    $course_id = $_POST['course_id'];
    $user = $_SESSION['user'];
    $user_id = $user['user_id'];

    // Check if already enrolled
    $checkEnrollment = $pdo->prepare("SELECT * FROM course_project.account_data WHERE course_id = ? AND user_id = ?");
    $checkEnrollment->execute([$course_id, $user_id]);
    
    if ($checkEnrollment->rowCount() > 0) {
        header("Location: course.php");
    }
    
    $currentDateTime = date('Y-m-d H:i:s'); // this is the mysql format i think
    

    $query = $pdo->prepare("INSERT INTO course_project.account_data (course_id, user_id, account_data_date) VALUES (?, ?, ?)");
    $result = $query->execute([$course_id, $user_id, $currentDateTime]);

    header("Location: home.php");
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
                    <form method="POST">
                        <td><?= $course['course_name'] ?></td>
                        <td><?= $course['description'] ?></td>
                        <td><?= $course['category_name'] ?></td>
                        <td><?= $course['teacher_name'] ?></td>
                        <td><?= $course['price'] ?></td>
                        <td><?= $course['starting_date'] ?></td>

                        <input type="hidden" name="course_id" value="<?= $course['course_id'] ?>"> <!-- hidden ID, used in enlisting courses-->
                        <td><button class="btn btn-primary p-0" style="border-radius: 0.5rem;" type="submit" name="submit">Sign Up</button></td>
                    </form>
                </tr>
            <?php endforeach ?>
            </table>

        </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>