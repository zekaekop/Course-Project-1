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
} else { # fetches courses, teachers, and categories tables
    $query = $pdo -> query("SELECT * FROM course_project.courses co 
                                            JOIN course_project.categories ca ON co.category = ca.category_id 
                                            JOIN course_project.teachers t ON co.teacher = t.teacher_id ");
    $courses = $query -> fetchAll();

    if($user['role'] == "teacher" || $user['role' == "admin"]){
        $query = $pdo -> query("SELECT * FROM course_project.categories");
        $categories = $query -> fetchAll();

        $query = $pdo -> query("SELECT * FROM course_project.teachers");
        $teachers = $query -> fetchAll();
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST"){

    # creating a course
    if(isset($_POST['createcourse_submit'])){

        _auth_user();

        $course_name = $_POST['course_name'];
        $description = $_POST['description'];

        $category_id = $_POST['category'];
        $teacher_id = $_POST['teacher'];

        $price = $_POST['price'];

        $course_starting_date = $_POST['course_starting_date'];
        $course_starting_time = $_POST['course_starting_time'];

        $course_starting_datetime = $course_starting_date . ' ' . $course_starting_time; # adds both inputs together

        $query = $pdo->prepare("INSERT INTO course_project.courses (course_name, description, category, teacher, price, starting_date) VALUES (?, ?, ?, ?, ?, ?)");
        $result = $query->execute([$course_name, $description, $category_id, $teacher_id, $price, $course_starting_datetime]);

        header("Location: courses.php");
    }
    
    # enlisting into a course
    if(isset($_POST['signup_submit'])){

        _auth_user();
        
        $course_id = $_POST['course_id'];
        $user = $_SESSION['user'];
        $user_id = $user['user_id'];

        // Check if already enrolled
        $checkEnrollment = $pdo->prepare("SELECT * FROM course_project.account_data WHERE course_id = ? AND user_id = ?");
        $checkEnrollment->execute([$course_id, $user_id]);
        
        if ($checkEnrollment->rowCount() > 0) { # wtf does this do??
            header("Location: course.php");
        }
        
        $currentDateTime = date('Y-m-d H:i:s'); // this is the mysql format i think
        

        $query = $pdo->prepare("INSERT INTO course_project.account_data (course_id, user_id, account_data_date) VALUES (?, ?, ?)");
        $result = $query->execute([$course_id, $user_id, $currentDateTime]);

        header("Location: home.php");
    }
}

// check if user is logged in
function _auth_user(){
    if (!isset($_SESSION['user'])) {
        header("Location: logout.php");
    }
}

?>

<div class="container mt-5">
    <h1 class="text-center">Current Courses</h1>

        <form method="POST">
            <div class="card w-100 mt-3 text-center">
                <div class="d-flex">
                    <input type="text" name="course_name" placeholder="Course Name Ex. Algebra 101 ..." id="">
                    <textarea name="description" placeholder="Description Ex. Solve Complex Math problems ..." id=""></textarea>
                    
                    <select name="category" id="">
                        <?php foreach($categories as $category): ?>
                            <option value="<?=$category['category_id'] ?>"><?= $category['category_name'] ?></option>
                        <?php endforeach ?>
                    </select>
                    <select name="teacher" id="">
                        <?php foreach($teachers as $teacher): ?>
                            <option value="<?=$teacher['teacher_id'] ?>"><?= $teacher['teacher_name'] ?></option>
                        <?php endforeach ?>
                    </select>
                    
                    <input type="number" name="price" placeholder="Course Price ..." id="">
                    <input type="date" name="course_starting_date" id="">
                    <input type="time" name="course_starting_time" id="">

                </div>
            </div>

            <?php if($user['role'] != "teacher"): ?>
                <button class="card p-3 mt-3 text-white w-100" style="border-radius: 0.5rem;" type="submit" name="createcourse_submit">Create a course</button>
            <?php endif ?>
        </form>

        <hr>

        <?php include('search.php'); ?>

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
                        <th>Actions</th>
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

                        <td>
                            <?php if($user['role'] != "teacher"): ?>
                                <button class="btn btn-primary p-0" style="border-radius: 0.5rem;" type="submit" name="signup_submit">Sign Up</button>
                            <?php endif ?>
                            <button class="btn btn-primary p-0" style="border-radius: 0.5rem;" type="submit" name="submit">Delete</button>
                            <button class="btn btn-primary p-0" style="border-radius: 0.5rem;" type="submit" name="submit">Edit</button>
                        </td>

                    </form>
                </tr>
            <?php endforeach ?>
            </table>

        </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>