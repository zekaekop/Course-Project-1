<?php

include "db.php";

include "base.php";

$user = $_SESSION['user'];

$search = '';

# if search isnt emty than do a filter on the table and get results, else just get all data from the table
if (isset($_GET['search'])){
    $search =   trim($_GET['search']);
    $query = $pdo->prepare("SELECT * FROM course_project.users usr
                            WHERE 
                            name LIKE ? OR 
                            role LIKE ? OR
                            mail LIKE ?");
    
    $query -> execute(["%$search%", "%$search%", "%$search%"]);
    $users = $query -> fetchAll();
} else {
    $query = $pdo -> query("SELECT * FROM course_project.users");
    $users = $query -> fetchAll();
}

?>

<div class="container mt-5">
    <h1 class="text-center">Current users</h1>

        <div class="card w-100 mt-3 text-center">
            <h3>Welcome <?= $user['name'] ?></h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Dicta ex pariatur iure quas tenetur accusantium est laudantium id expedita, autem ea porro quos officiis deleniti, cumque error neque exercitationem praesentium?</p>
        </div>

        <br>

        <?php include('search.php'); ?>

        <br>

        <div class="card w-100 mt-3">
            <h3 class="text-center">Active users</h3>

            <table class="text-center w-100">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Role</th>
                        <th>Mail</th>
                    </tr>
                </thead>
            <?php foreach($users as $user): ?>
                <tr>
                    <form method="POST">
                        <td><?= $user['user_id'] ?></td>
                        <td><?= $user['name'] ?></td>
                        <td><?= $user['password'] ?></td>
                        <td><?= $user['role'] ?></td>
                        <td><?= $user['mail'] ?></td>

                        <!-- <input type="hidden" name="user_id" value=" $user['user_id'] "> -->
                    </form>
                </tr>
            <?php endforeach ?>
            </table>

        </div>
</div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>