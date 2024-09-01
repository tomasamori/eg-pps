<?php
session_start();
include("../db.php");
include("../includes/header.php");
?>

<style>
    body {
        background-color: #f3f5fc;
    }

    .table {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .table th {
        color: white;
        background-color: #3aa661;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    .table-hover tbody tr:hover {
        background-color: #f1f3f9;
    }

    .table th,.table td {
        width: 33.33%;
    }
</style>

<div class="container p-4">
    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center mb-4">
                PPs asignadas
            </h2>
            <div class="card card-body">
                <div class="row mb-3">
                    <!-- Columna para el selector de año -->
                    <div class="col-md-10">
                        <form action="" method="GET">
                            <div class="form-group">
                                <select name="year" id="year" class="form-control" onchange="this.form.submit()">
                                    <option value="" disabled selected>Seleccionar año</option>
                                    <?php
                                    $year_query = "SELECT DISTINCT YEAR(start_date) AS year FROM spp ORDER BY year DESC";
                                    $result_year = mysqli_query($conn, $year_query);
                                    while ($row_year = mysqli_fetch_assoc($result_year)) {
                                        echo "<option value='" . $row_year['year'] . "'>" . $row_year['year'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </form>
                    </div>
                    <!-- Columna para el botón de imprimir -->
                    <div class="col-md-2 d-flex justify-content-end align-items-center">
                        <a href="generate_pdf.php?year=<?php echo isset($_GET['year']) ? $_GET['year'] : ''; ?>" class="btn btn-success">Imprimir</a>
                    </div>
                </div>

                <table class="table">
                    <thead>
                        <tr class="text-center">
                            <th>Estudiante</th>
                            <th>Organización</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $year = isset($_GET['year']) ? $_GET['year'] : '';
                        $query = "SELECT spp.spp_id, 
                                    spp.organization_name, 
                                    spp.organization_email, 
                                    spp.organization_phone, 
                                    spp.organization_address, 
                                    spp.organization_city, 
                                    spp.organization_state, 
                                    spp.organization_zip, 
                                    spp.start_date, 
                                    spp.end_date, 
                                    spp.status, 
                                    student.name AS student_name, 
                                    student.email AS student_email, 
                                    supervisor.name AS supervisor_name, 
                                    supervisor.email AS supervisor_email, 
                                    mentor.name AS mentor_name, 
                                    mentor.email AS mentor_email
                                  FROM spp
                                  LEFT JOIN spp_user ON spp.spp_id = spp_user.spp_id
                                  LEFT JOIN user AS student ON spp_user.student_id = student.user_id
                                  LEFT JOIN user AS supervisor ON spp_user.supervisor_id = supervisor.user_id
                                  LEFT JOIN user AS mentor ON spp_user.mentor_id = mentor.user_id
                                  WHERE spp_user.mentor_id = $user_id";

                        if (!empty($year)) {
                            $query .= " AND YEAR(spp.start_date) = $year";
                        }

                        $result_spp = mysqli_query($conn, $query);
                        while ($row = mysqli_fetch_array($result_spp)) { ?>
                            <tr>
                                <td class="text-center"><?php echo $row['student_name'] ?></td>
                                <td class="text-center"><?php echo $row['organization_name'] ?></td>
                                <td class="text-center"><?php echo $row['status'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<?php include("../includes/footer.php") ?>