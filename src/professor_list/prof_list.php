<?php session_start(); ?>
<?php include("../db.php") ?>
<?php include("../includes/header.php") ?>

<div class="container p-4 bg-light">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-body">
                <h2 class="text-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="45" height="45" fill="currentColor" class="bi bi-file-earmark-person-fill" viewBox="0 0 16 16">
                        <path d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0m2 5.755V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1v-.245S4 12 8 12s5 1.755 5 1.755" />
                    </svg>
                    Profesores Disponibles
                </h2>
                <table>
                    <tbody>
                        <?php
                        $query = "SELECT user_id, user.name, user.email, career.name AS career_name FROM user INNER JOIN career ON user.career_id = career.career_id WHERE role_id = '2'";
                        $result_users = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_array($result_users)) { ?>
                            <tr>
                                <td style="font-size: 20px;"><img src="../img/utn-logo.png" width="45">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $row['name'] ?></td>
                                <td class="text-end">
                                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#exampleModal<?php echo $row['user_id']; ?>">
                                        Detalles
                                    </button>
                                </td>
                            </tr>

                            <div class="modal fade" id="exampleModal<?php echo $row['user_id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel"><?php echo $row['name'] ?></h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-5 text-center">
                                                    <img src="../img/utn-logo.png" width="70">
                                                </div>
                                                <div class="col-md-7">
                                                    <strong>Correo</strong>
                                                    <br>
                                                    <?php echo $row['email'] ?>
                                                    <br>
                                                    <strong>Carrera</strong>
                                                    <br>
                                                    <?php echo $row['career_name'] ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>

<?php include("../includes/footer.php") ?>