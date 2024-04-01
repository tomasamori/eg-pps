<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema PPS</title>
    <!-- BOOSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- FONT AWESOME -->
    <script src="https://kit.fontawesome.com/cafe638f84.js" crossorigin="anonymous"></script>
</head>
<style>
  body {
        margin: 0;
        padding-bottom: 50px; /* Ajusta este valor según la altura del footer */
    }
</style>
<body>

<?php
  require_once __DIR__ . '/../db.php';

  function getUnreadNotifications($userId) {
    global $conn;
    $sql = "SELECT COUNT(*) AS total FROM notification WHERE receiver_id = ? AND status = 'No leída'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    return $row;
  }

  if (isset($_SESSION["user_id"])) {
    $unreadNotifications = getUnreadNotifications($_SESSION["user_id"])["total"];
  }
  ?>

<nav class="navbar navbar-expand-lg bg-body-tertiary" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="../index.php">
        <img src="../img/logo - utn.png" alt="Logo-UTN" class="navbar-brand-img mr-2 img-fluid" style="max-height: 60px;">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="../professor_list/prof_list.php">Listado de profesores</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="../spp/spp.php">Solicitud de PPS</a>
        </li>
        <li class="nav-item">
          <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Menus
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="../user/user.php">Usuarios</a></li>
            <li><a class="dropdown-item" href="../career/career.php">Carreras</a></li>
          </ul>
        </li>
      </ul>
      <form class="d-flex">
        <?php if (isset($_SESSION['user_id'])): ?>
          <div class="dropdown me-4">
            <button class="btn btn-primary position-relative" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa-solid fa-bell"></i>
              <?php if ($unreadNotifications > 0): ?>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                  <?= $unreadNotifications ?>
                  <span class="visually-hidden">Notificaciones no leídas</span>
                </span>
              <?php endif; ?>
            </button>
            <ul class="dropdown-menu" aria-labelledby="notificationDropdown">
              <li><a class="dropdown-item" href="#">Notification 1</a></li>
              <li><a class="dropdown-item" href="#">Notification 2</a></li>
              <li><a class="dropdown-item" href="#">Notification 3</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">Ver todas las notificaciones</a></li>
            </ul>
          </div>
          <a class="btn btn-outline-danger me-2" href="../auth/logout.php">Cerrar Sesión</a>
          <a class="btn btn-outline-secondary" href="../user/user_edit.php">Editar Perfil</a>
        <?php else: ?>
          <a class="btn btn-outline-info me-2" href="../auth/login.php">Acceder</a>
          <a class="btn btn-outline-info" href="../auth/signup.php">Registrarse</a>
        <?php endif; ?>
      </form>
    </div>
  </div>
</nav>