<?php

include "db.php";

include "base.php";

$user = $_SESSION['user'];

$search = '';

# if search isnt emty than do a filter on the table and get results, else just get all data from the table
if($user['role'] == "admin"){
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

    if ($_SERVER["REQUEST_METHOD"] == "POST"){

        # deleting a fetched_user
        if(isset($_POST['delete_submit'])){
            
            _auth_user();

            $user_id = $_POST['fetched_user_id'];

            $query = $pdo->prepare("DELETE FROM users WHERE user_id LIKE ?");
            $result = $query->execute([$user_id]);

            header("location: admin_panel.php");
        }

        # editing users
        if(isset($_POST['update_submit'])){

            _auth_user();
            
            $user_id = $_POST['fetched_user_id'];

            $edit_fetched_user_name = $_POST['edit_fetched_user_name'];
            $edit_fetched_user_password = $_POST['edit_fetched_user_password'];
            $edit_fetched_user_role = $_POST['edit_fetched_user_role'];
            $edit_fetched_user_mail = $_POST['edit_fetched_user_mail'];
            
            $query = $pdo->prepare("UPDATE users SET name = ?, password = ?, role = ?, mail = ? WHERE user_id = ?");
            $result = $query->execute([$edit_fetched_user_name, $edit_fetched_user_password, $edit_fetched_user_role, $edit_fetched_user_mail, $user_id]);
            
            header("Location: admin_panel.php");
        }

        # creating a fetched_user
        if(isset($_POST['createfetched_user_submit'])){

            _auth_user();

            $fetched_user_name = $_POST['create_username'];

            $fetched_user_password = $_POST['create_password'];
            $fetched_user_role = $_POST['create_role'];
            $fetched_user_mail = $_POST['create_mail'];

            $query = $pdo->prepare("INSERT INTO users (name, password, role, mail) VALUES (?, ?, ?, ?)");
            $result = $query->execute([$fetched_user_name, $fetched_user_password, $fetched_user_role, $fetched_user_mail]);

            header("Location: admin_panel.php");
        }
    }
} else {
    header("Location: home.php");
    exit();
}

// check if user is logged in
function _auth_user(){
    if (!isset($_SESSION['user'])) {
        header("Location: logout.php");
    }
}

?>

<div class="container mt-5">
    <h1 class="text-center text-shadow"><b>Current users</b></h1>

        <!-- this should only be visiable to teachers and admins -->
        <?php if($user['role'] == "admin"): ?>
            <form method="POST">
                <div class="card w-100 mt-5">
                        <input class="w-100" type="text" name="create_username" placeholder="User Name Ex. Ryan Smith ..." id="" required>
                        <input class="w-100" type="text" name="create_password" placeholder="User Password Ex. Q!@2M#zE$4 ..." id="" required>

                        <select name="create_role" id="" required>
                                <option value="student">Student</option>
                                <option value="teacher">Teacher</option>
                                <option value="admin">Admin</option>
                        </select>

                        <input class="w-100" type="text" name="create_mail" placeholder="User Mail Ex. Example@gmail.com ..." id="" required>
                </div>

                <button class="card p-3 mt-3 text-white w-100" style="border-radius: 0.5rem;" type="submit" name="createfetched_user_submit"><b>Create User</b></button>

            </form>
        <?php endif ?>

        <hr>

        <?php include('search.php'); ?>

        <br>

        <div class="card w-100 mt-3">
            <h3 class="text-center"><b>Active users</b></h3>

            <div class="table-responsive">
                <table class="text-center w-100">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Username</th>
                            <th>Password</th>
                            <th>Role</th>
                            <th>Mail</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                <?php foreach($users as $fetched_user): ?>
                    <tr>
                            <td><?= $fetched_user['user_id'] ?></td>
                            <td><?= $fetched_user['name'] ?></td>
                            <td><?= $fetched_user['password'] ?></td>
                            <td><?= $fetched_user['role'] ?></td>
                            <td><?= $fetched_user['mail'] ?></td>

                            <td>
                            <?php if($user['role'] == "admin"): ?>
                                <button class="btn btn-primary p-0 w-100" style="border-radius: 0.5rem;" data-bs-toggle="modal" data-bs-target="#deletemodal<?= $fetched_user['user_id'] ?>">Delete</button>
                                <button class="btn btn-primary p-0 w-100" style="border-radius: 0.5rem;" data-bs-toggle="modal" data-bs-target="#editmodal<?= $fetched_user['user_id'] ?>">Edit</button>
                            <?php endif ?>
                            </td>
                    </tr>
                <?php endforeach ?>
                </table>
            </div>

        </div>
</div>

<!-- This is the old modal from the music project -->
<!-- https://getbootstrap.com/docs/5.3/components/modal/ -->
<!-- Modal -->
<?php foreach($users as $fetched_user): ?>
    <div class="modal fade" id="editmodal<?= $fetched_user['user_id']?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit User</h5>
                        <button type="button" class="btn-close"  style="background-color: white;"  data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" name="fetched_user_id" value="<?= $fetched_user['user_id'] ?>" required>
                        <input type="text" class="form-control" name="edit_fetched_user_name" value="<?= $fetched_user['name'] ?>" required>
                        <input class="w-100" type="text" name="edit_fetched_user_password" value="<?= $fetched_user['password'] ?>" placeholder="User Password Ex. Q!@2M#zE$4 ..." id="" required>

                        <select class="w-100" name="edit_fetched_user_role" selected="<?= $fetched_user['role'] ?>" id="" required>
                                <option value="student">student</option>
                                <option value="teacher">teacher</option>
                                <option value="admin">admin</option>
                        </select>

                        <input class="w-100" type="text" name="edit_fetched_user_mail" value="<?= $fetched_user['mail'] ?>" placeholder="User Mail Ex. Example@gmail.com ..." id="" required>
                        
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary w-100" type="submit" name="update_submit">Update</button>
                        <button class="btn btn-primary w-100" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deletemodal<?=$fetched_user['user_id']?>" tabindex="-1" aria-labelledby="deletemodallabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deletemodallabel">Confirm Delete</h1>
                <button type="button" class="btn-close" style="background-color: white;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this?
            </div>
            <div class="modal-footer">
                
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Cancel</button>
                <form method="POST">
                    <input type="hidden" name="fetched_user_id" id="" value=<?=$fetched_user['user_id']?>>
                    <button class="btn btn-primary"  type="submit" name="delete_submit">Delete</button>
                </form>
            </div>
            </div>
        </div>
    </div>
<?php endforeach ?>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>