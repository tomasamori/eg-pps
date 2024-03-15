<?php session_start(); ?>
<?php include("../db.php") ?>
<?php include("../includes/header.php") ?>

<div class="container p-4">
    <div class="row">
        <div class="col-md-12">
            <?php if (isset($_SESSION['message'])) { ?>
                <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['message'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php session_unset();
            } ?>
            <div class="card card-body">
                <h2 class="text-center mb-4">Profesores Disponibles</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-center">
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Carrera</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $query = "SELECT user.name, user.email, career.name AS career_name FROM user INNER JOIN career ON user.career_id = career.career_id WHERE role_id = '2'";
                        $result_users = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_array($result_users)) { ?>
                            <tr>
                                <td><?php echo $row['name'] ?></td>
                                <td><?php echo $row['email'] ?></td>
                                <td><?php echo $row['career_name'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include("../includes/footer.php") ?>