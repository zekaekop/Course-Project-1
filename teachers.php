<?php

include "db.php";

include "base.php";

$user = $_SESSION['user'];

$search = '';

# if search isnt emty than do a filter on the table and get results, else just get all data from the table
if (isset($_GET['search'])){
    $search =   trim($_GET['search']);
    $query = $pdo -> prepare("SELECT * FROM course_project.teachers WHERE 
                                                teacher_name LIKE ? OR 
                                                profesion LIKE ?");
    
    $query -> execute(["%$search%", "%$search%"]);
    $teachers = $query -> fetchAll();
} else {
    $query = $pdo -> query("SELECT * FROM course_project.teachers");
    $teachers = $query -> fetchAll();
}
?>

<div class="container mt-5">
    <h1 class="text-center">Current Teachers</h1>

        <div class="card w-100 mt-3 text-center">
            <h3>Welcome <?= $user['name'] ?></h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta ex pariatur iure quas tenetur accusantium est laudantium id expedita, autem ea porro quos officiis deleniti, cumque error neque exercitationem praesentium?</p>
        </div>

        <?php include('search.php'); ?>

        <div class="card w-100 mt-3">
            <h3 class="text-center">Available Teachers</h3>

            <table class="text-center w-100">
                <thead>
                    <tr>
                        <th>Teacher Name</th>
                        <th>Profesion</th>
                    </tr>
                </thead>
            <?php foreach($teachers as $teacher): ?>
                <tr>
                    <td><?= $teacher['teacher_name'] ?></td>
                    <td><?= $teacher['profesion'] ?></td>
                </tr>
            <?php endforeach ?>
            </table>

        </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>