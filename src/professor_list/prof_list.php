<?php
session_start();
include("../includes/header.php");
include("../db.php");

function getTotalProfessors($conn, $role_id, $student_id = null)
{
    $query = "SELECT COUNT(DISTINCT user.user_id) AS total 
              FROM user 
              INNER JOIN career ON user.career_id = career.career_id 
              LEFT JOIN spp_user ON spp_user.mentor_id = user.user_id
              LEFT JOIN spp ON spp_user.spp_id = spp.spp_id
              WHERE role_id = ?";

    if ($student_id) {
        $query .= " AND user.career_id = (SELECT career_id FROM user WHERE user_id = ?)";
    }

    $stmt = $conn->prepare($query);
    if ($student_id) {
        $stmt->bind_param("ii", $role_id, $student_id);
    } else {
        $stmt->bind_param("i", $role_id);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row['total'];
}

$role_id = null;
$query = "SELECT role_id FROM role WHERE name = 'Profesor'";
$result = $conn->query($query);
if ($result && $result->num_rows > 0) {
    $role_id = $result->fetch_assoc()['role_id'];
}

// Get the total number of professors
$student_id = $_SESSION['user_id'] ?? null;
$total_professors = getTotalProfessors($conn, $role_id, $student_id);

// Pagination config
$prof_per_page = 6;
$page_num = $_REQUEST['page_num'] ?? 1;
$start = ($page_num - 1) * $prof_per_page;
$total_pages = ceil($total_professors / $prof_per_page);

// Get professors
$query = "SELECT user.user_id, user.name, user.email, user.photo, career.name AS career_name, 
                 COALESCE(SUM(spp.status = 'En proceso'), 0) AS spp_count
          FROM user 
          INNER JOIN career ON user.career_id = career.career_id 
          LEFT JOIN spp_user ON spp_user.mentor_id = user.user_id
          LEFT JOIN spp ON spp_user.spp_id = spp.spp_id
          WHERE role_id = ?";

if ($student_id) {
    $query .= " AND user.career_id = (SELECT career_id FROM user WHERE user_id = ?)";
}

$query .= " GROUP BY user.user_id 
            HAVING spp_count < 10
            LIMIT ?, ?";

$stmt = $conn->prepare($query);
if ($student_id) {
    $stmt->bind_param("iiii", $role_id, $student_id, $start, $prof_per_page);
} else {
    $stmt->bind_param("iii", $role_id, $start, $prof_per_page);
}
$stmt->execute();
$result_users = $stmt->get_result();
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

    .pagination .page-link {
        color: white;
        background-color: #3aa661;
        border-color: #3aa661;
    }

    .pagination .page-item.active .page-link {
        color: #3aa661;
        background-color: white;
        border-color: #3aa661;
    }

    .pagination .page-link:hover {
        color: white;
        background-color: #2f8b4f;
        border-color: #2f8b4f;
    }

    .table th,
    .table td {
        width: 33.33%;
    }
</style>

<div class="container mt-5">
    <h1 class="text-center mb-5">Profesores Disponibles</h1>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Profesor</th>
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
                        <a class="page-link" href="prof_list.php?page_num=1" aria-label="Primera página">
                            <span aria-hidden="true">&laquo;&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="prof_list.php?page_num=<?php echo $page_num - 1; ?>" aria-label="Anterior">
                            <span aria-hidden="true"><?php echo $page_num - 1; ?></span>
                        </a>
                    </li>
                <?php } ?>

                <li class="page-item active"><a class="page-link"><?php echo $page_num; ?></a></li>

                <?php if ($page_num < $total_pages) { ?>
                    <li class="page-item">
                        <a class="page-link" href="prof_list.php?page_num=<?php echo $page_num + 1; ?>" aria-label="Siguiente">
                            <span aria-hidden="true"><?php echo $page_num + 1; ?></span>
                        </a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="prof_list.php?page_num=<?php echo $total_pages; ?>" aria-label="Última página">
                            <span aria-hidden="true">&raquo;&raquo;</span>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</div>

<?php include("../includes/footer.php"); ?>