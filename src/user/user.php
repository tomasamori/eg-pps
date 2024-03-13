<?php session_start(); ?>
<?php include("../db.php") ?>
<?php include("../includes/header.php") ?>

<div class="container p-4">
    <div class="row">
        <div class="col-md-3">

            <?php if (isset($_SESSION['message'])) { ?>
                <div class="alert alert-<?= $_SESSION['message_type'] ?> alert-dismissible fade show" role="alert">
                    <?= $_SESSION['message'] ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php session_unset();
            } ?>
            <div class="card card-body">

                <form action="user_create.php" method="POST">
                    <div class="form-group m-2">
                        <input type="email" name="email" class="form-control" placeholder="Email" autofocus required>
                    </div>
                    <div class="form-group m-2">
                        <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                    </div>
                    <div class="form-group m-2">
                        <input type="text" name="name" class="form-control" placeholder="Nombre y Apellido" required>
                    </div>
                    <?php
                    $query = "SELECT * FROM career";
                    $result_career = mysqli_query($conn, $query);
                    ?>
                    <div class="form-group m-2">
                        <select name="career_id" class="form-control" required>
                            <option value="">Selecciona una carrera</option>
                            <?php while ($row = mysqli_fetch_assoc($result_career)) { ?>
                                <option value="<?php echo $row['career_id']; ?>"><?php echo $row['name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <br>
                    <input type="submit" class="btn btn-success btn-block mx-auto d-block" name="user_create" value="Guardar Usuario">
                </form>


            </div>
        </div>
        <div class="col-md-8">
            <table class="table table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Email</th>
                        <th>Nombre y Apellido</th>
                        <th>Carrera</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = "SELECT user.user_id, user.email, user.password, user.name, career.name AS career_name FROM user INNER JOIN career ON user.career_id = career.career_id WHERE user.deleted=0";
                    $result_users = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_array($result_users)) { ?>
                        <tr>
                            <td><?php echo $row['user_id'] ?></td>
                            <td><?php echo $row['email'] ?></td>
                            <td><?php echo $row['name'] ?></td>
                            <td><?php echo $row['career_name'] ?></td>
                            <td class="text-center">
                                <a href="user_update.php?user_id=<?php echo $row['user_id'] ?>" class="btn btn-primary" role="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
                                        <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001" />
                                    </svg>
                                </a>
                                <a href="user_delete.php?user_id=<?php echo $row['user_id'] ?>" class="btn btn-danger" role="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0" />
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>


            </table>
        </div>
    </div>
</div>

<?php include("../includes/footer.php") ?>