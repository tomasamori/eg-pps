<?php
session_start();
include("../includes/header.php");
include("../db.php");

if (isset($_SESSION['user_id']) && $_SESSION['role_name'] == 'Alumno') {
    
    $query = "SELECT career_id FROM user WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $career_id = $result->fetch_assoc()['career_id'];
    
    // Función para obtener el total de supervisors
    function getTotalSupervisors($conn, $career_id)
    {
        $query = "SELECT COUNT(DISTINCT user.user_id) AS total 
              FROM user 
              WHERE role_id = (SELECT role_id FROM role WHERE name = 'Responsable' AND career_id = ?)";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $career_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    $total_supervisors = getTotalSupervisors($conn, $career_id);

    $supervisors_per_page = 6;
    $page_num = $_REQUEST['page_num'] ?? 1;
    $start = ($page_num - 1) * $supervisors_per_page;
    $total_pages = ceil($total_supervisors / $supervisors_per_page);

    $query = "SELECT user.user_id, user.name, user.email, user.photo, career.name AS career_name
          FROM user 
          INNER JOIN career ON user.career_id = career.career_id 
          WHERE user.role_id = (SELECT role.role_id FROM role WHERE role.name = 'Responsable') AND user.career_id = ?
          LIMIT ?, ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("iii", $career_id, $start, $supervisors_per_page);
    $stmt->execute();
    $result_users = $stmt->get_result();

} else {
    
    function getTotalSupervisors($conn)
    {
        $query = "SELECT COUNT(DISTINCT user.user_id) AS total 
              FROM user 
              WHERE role_id = (SELECT role_id FROM role WHERE name = 'Responsable')";

        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return $row['total'];
    }

    $total_supervisors = getTotalSupervisors($conn);

    $supervisors_per_page = 6;
    $page_num = $_REQUEST['page_num'] ?? 1;
    $start = ($page_num - 1) * $supervisors_per_page;
    $total_pages = ceil($total_supervisors / $supervisors_per_page);

    $query = "SELECT user.user_id, user.name, user.email, user.photo, career.name AS career_name
          FROM user 
          INNER JOIN career ON user.career_id = career.career_id 
          WHERE role_id = (SELECT role_id FROM role WHERE name = 'Responsable') 
          LIMIT ?, ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $start, $supervisors_per_page);
    $stmt->execute();
    $result_users = $stmt->get_result();
}

?>

<div class="container mt-5">
    <h1 class="text-center mb-5">Responsables Disponibles</h1>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Responsable</th>
                        <th>Carrera</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result_users->fetch_assoc()) { ?>
                        <tr class="align-middle">
                            <td>
                                <img src="<?php echo htmlspecialchars($row['photo'], ENT_QUOTES, 'UTF-8'); ?>" width="45" height="45" class="rounded-circle me-3">
                                <?php echo htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8'); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($row['career_name'], ENT_QUOTES, 'UTF-8'); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>

            <ul class="pagination justify-content-center pb-5 pt-5 mb-0">
                <?php if ($page_num > 1) { ?>
                    <li class="page-item">
                        <a class="page-link" href="supervisors_list.php?page_num=1" aria-label="Primera página">
                            <span aria-hidden="true">&laquo;&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="supervisors_list.php?page_num=<?php echo $page_num - 1; ?>" aria-label="Anterior">
                            <span aria-hidden="true"><?php echo $page_num - 1; ?></span>
                        </a>
                    </li>
                <?php } ?>

                <li class="page-item active"><a class="page-link"><?php echo $page_num; ?></a></li>

                <?php if ($page_num < $total_pages) { ?>
                    <li class="page-item">
                        <a class="page-link" href="supervisors_list.php?page_num=<?php echo $page_num + 1; ?>" aria-label="Siguiente">
                            <span aria-hidden="true"><?php echo $page_num + 1; ?></span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="supervisors_list.php?page_num=<?php echo $total_pages; ?>" aria-label="Última página">
                            <span aria-hidden="true">&raquo;&raquo;</span>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>

<?php include("../includes/footer.php"); ?>