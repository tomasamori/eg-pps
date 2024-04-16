<?php
session_start();
include("../db.php");
include("../includes/header.php")
?>

<div class="container p-4 bg-light">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-body">
                <h2 class="text-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-person-lines-fill" viewBox="0 0 16 16">
                        <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5 6s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zM11 3.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5m.5 2.5a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1zm2 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h2a.5.5 0 0 0 0-1z" />
                    </svg>
                    Responsables
                </h2>
                <div class="card-container" style="display: flex; flex-wrap: wrap;">
                    <?php
                    $query = "SELECT role_id FROM role WHERE name = 'Admin'";
                    $result = $conn->query($query);
                    if ($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $role_id = $row['role_id'];
                        $query = "SELECT user_id, user.name, user.email, career.name AS career_name FROM user  INNER JOIN career ON user.career_id = career.career_id WHERE role_id = $role_id";
                        $result_users = mysqli_query($conn, $query);
                    }
                    while ($row = mysqli_fetch_array($result_users)) { ?>
                        <div class="card" style="width: 18rem; margin: 10px;">
                            <div class="card-header text-center">
                                <?php echo $row['career_name'] ?>
                            </div>
                            <img src="../img/logo - utn.png" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['name'] ?></h5>
                                <p class="card-text"><?php echo $row['email'] ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </div>

            </div>
        </div>
    </div>
</div>
<?php include("../includes/footer.php") ?>