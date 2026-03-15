<?php

include "db.php";

include "base.php";

$user = $_SESSION['user'];

$search = '';

# if search isnt emty than do a filter on the table and get results, else just get all data from the table
if (isset($_GET['search'])){
    $search =   trim($_GET['search']);
    $query = $pdo -> prepare("SELECT * FROM categories WHERE 
                                                category_name LIKE ? ");
    
    $query -> execute(["%$search%"]);
    $categories = $query -> fetchAll();
} else {
    $query = $pdo -> query("SELECT * FROM categories");
    $categories = $query -> fetchAll();
}


if ($_SERVER["REQUEST_METHOD"] == "POST"){

    # deleting a category
    if(isset($_POST['delete_submit'])){

        _auth_user();

        $category_id = $_POST['category_id'];

        $query = $pdo->prepare("DELETE FROM categories WHERE category_id LIKE ?");
        $result = $query->execute([$category_id]);

        header("location: categories.php");
    }

    # editing categories
    if(isset($_POST['update_submit'])){

        _auth_user();
        
        $category_id = $_POST['category_id'];

        $category_name = $_POST['category_name'];
        
        $query = $pdo->prepare("UPDATE categories SET category_name = ? WHERE category_id = ?");
        $result = $query->execute([$category_name, $category_id]);
        
        header("Location: categories.php");
    }

    # creating a category
    if(isset($_POST['createcategory_submit'])){

        _auth_user();

        $category_name = $_POST['category_name'];

        $query = $pdo->prepare("INSERT INTO categories (category_name) VALUES (?)");
        $result = $query->execute([$category_name]);

        header("Location: categories.php");
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
    <h1 class="text-center text-shadow"><b>Current Categories</b></h1>

        <!-- this should only be visiable to teachers and admins -->
         <?php if($user['role'] == "teacher" || $user['role'] == "admin"): ?>
            <form method="POST">
                <div class="card w-100 mt-5">
                        <input class="w-100" type="text" name="category_name" placeholder="Category Name Ex. Science ..." id="" required>
                </div>

                <button class="card p-3 mt-3 text-white w-100" style="border-radius: 0.5rem;" type="submit" name="createcategory_submit"><b>Create category</b></button>

            </form>
        <?php endif ?>

        <hr>

        <?php include('search.php'); ?>

        <div class="card w-100 mt-3">
            <h3 class="text-center"><b>Available Categories</b></h3>

            <div class="table-responsive">
                <table class="text-center w-100">
                    <thead>
                        <tr>
                            <th>Category Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                <?php foreach($categories as $category): ?>
                    <tr>
                        <td><?= $category['category_name'] ?></td>
                        <td>
                            <?php if($user['role'] == "teacher" || $user['role'] == "admin"): ?>
                                <button class="btn btn-primary p-0 w-100" style="border-radius: 0.5rem;" data-bs-toggle="modal" data-bs-target="#deletemodal<?= $category['category_id'] ?>">Delete</button>
                                <button class="btn btn-primary p-0 w-100" style="border-radius: 0.5rem;" data-bs-toggle="modal" data-bs-target="#editmodal<?= $category['category_id'] ?>">Edit</button>
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
<?php foreach($categories as $category): ?>
    <div class="modal fade" id="editmodal<?= $category['category_id']?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit category</h5>
                        <button type="button" class="btn-close"  style="background-color: white;"  data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" name="category_id" value="<?= $category['category_id'] ?>" required>
                        <input type="text" class="form-control" name="category_name" value="<?= $category['category_name'] ?>" required>
                        
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary w-100" type="submit" name="update_submit">Update</button>
                        <button class="btn btn-primary w-100" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deletemodal<?=$category['category_id']?>" tabindex="-1" aria-labelledby="deletemodallabel" aria-hidden="true">
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
                    <input type="hidden" name="category_id" id="" value=<?=$category['category_id']?>>
                    <button class="btn btn-primary"  type="submit" name="delete_submit">Delete</button>
                </form>
            </div>
            </div>
        </div>
    </div>
<?php endforeach ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>