<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema PPS</title>
  <!-- Bootstrap 5.3.3 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <!-- Font Awesome -->
  <script src="https://kit.fontawesome.com/cafe638f84.js" crossorigin="anonymous"></script>
</head>
<style>
  .nav-link {
    color: black;
  }

  .nav-link:hover {
    color: gray;
  }

  .btn:focus {
    outline: none;
    background-color: #3F9B5E;
    box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.2);
  }

  .form-control:focus {
    border-color: #3aa661;
    box-shadow: none;
  }

  @media (max-width: 990px) {
    .navbar-brand {
      display: none;
    }

    .navbar {
      position: relative;
    }

    #userButtons,
    #authButtons {
      position: absolute;
      top: 10px;
      right: 10px;
      display: flex;
      justify-content: flex-end;
      align-items: center;
      gap: 5px;
      z-index: 1050;
    }

    .collapse {
      position: static;
      width: 100%;

    }

    .navbar-collapse {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
    }

    .navbar-nav {
      display: flex;
      flex-direction: column;
      width: 100%;
      margin: 0;
      padding: 0;
    }

    .nav-link {
      display: block;
      padding: 10px 15px;
      text-align: center;
    }
  }
</style>

<body>

  <?php
  require_once __DIR__ . '/../db.php';
  if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    
    $query = "SELECT role_id FROM role WHERE name = 'Admin'";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $role_admin = $row['role_id'];
    }
    $query = "SELECT role_id FROM user WHERE user_id = '$user_id'";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $role_user = $row['role_id'];
    }
  }


  function getUnreadNotifications($userId)
  {
    global $conn;
    $sql = "SELECT COUNT(*) AS total FROM notification WHERE receiver_id = ? AND status = 'No leída' AND deleted = 0";
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

  <nav class="navbar navbar-expand-lg shadow-sm sticky-top" style="background-color: #ffffff;">
    <div class="container">
      <a class="navbar-brand me-4" href="../index.php">
        <img src="../img/utn_logo.png" alt="Logo de la Universidad Tecnológica Nacional" height="40">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 fw-bold">
          <li class="nav-item me-4">
            <a class="nav-link" href="../professor_list/prof_list.php">Profesores</a>
          </li>
          <?php if (isset($_SESSION["user_id"])) { ?>
            <li class="nav-item me-4">
              <a class="nav-link" href="../spp/spp_main.php">PPS</a>
            </li>
          <?php } ?>
        </ul>
      </div>
      <?php if (isset($_SESSION['user_id'])): ?>
        <div id="userButtons" class="d-flex">
          <div class="dropstart me-2">
            <button type="button" class="btn btn-dark btn-sm rounded-circle" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false" title="Notificaciones">
              <i class="fa-solid fa-bell"></i>
              <?php if ($unreadNotifications > 0): ?>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                  <?= $unreadNotifications ?>
                  <span class="visually-hidden">Notificaciones no leídas</span>
                </span>
              <?php endif; ?>
            </button>
            <ul class="dropdown-menu text-truncated" aria-labelledby="notificationDropdown">
              <li>
                <h6 class="dropdown-header">Notificaciones</h6>
              </li>
              <?php
              $sql = "SELECT * FROM notification WHERE receiver_id = ? AND deleted = 0 ORDER BY timestamp DESC";
              $stmt = $conn->prepare($sql);
              $stmt->bind_param("i", $_SESSION["user_id"]);
              $stmt->execute();
              $result = $stmt->get_result();
              if ($result->num_rows === 0): ?>
                <li><a class='dropdown-item fw-lighter'><small>No hay notificaciones</small></a></li>
                <?php else:
                while ($row = $result->fetch_assoc()): ?>
                  <div class="d-flex align-items-center justify-content-between">
                    <button class="dropdown-item notification-link" data-notification-id="<?php echo $row["notification_id"]; ?>">
                      <?php if ($row["status"] === "No leída"): ?>
                        <strong><small class="d-inline-block text-truncate" style="max-width: 350px;">
                            <?php echo $row["message"]; ?>
                          </small></strong>
                      <?php else: ?>
                        <small class="d-inline-block text-truncate" style="max-width: 300px;">
                          <?php echo $row["message"]; ?>
                        </small>
                      <?php endif; ?>
                    </button>
                    <div class="text-align-end ms-2 me-2">
                      <button class="btn btn-outline-secondary mb-1 delete-notification" data-notification-id="<?php echo $row["notification_id"]; ?>" title="Eliminar notificación">
                        <i class="fa-solid fa-trash fa-xs" style="color: #ff0000;"></i>
                      </button>
                    </div>
                  </div>
                <?php endwhile; ?>
              <?php endif; ?>
              <li>
                <hr class="dropdown-divider">
              </li>
              <div class="text-start">
                <a id="mark-all-as-read" class="btn btn-link text-secondary-emphasis" href="#"><small>Marcar todas como leídas</small></a>
              </div>
              </li>
            </ul>
          </div>

          <div class="nav-item dropstart">
            <button type="button" class="btn btn-dark btn-sm rounded-circle" data-bs-toggle="dropdown" aria-expanded="false" title="Mi Cuenta">
              <i class="fa-solid fa-user"></i>
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="../user/user_edit.php">Editar Perfil</a></li>
              <?php
              if ($role_admin == $role_user) {
              ?>
                <li><a class="dropdown-item" href="../crud/crud.php">Portal Administrativo</a></li>
              <?php
              }

              ?>

              <li><a class="dropdown-item " href="../auth/logout.php">Cerrar Sesión</a></li>
            </ul>
          </div>
        </div>

      <?php else: ?>
        <div id="authButtons" class="d-flex">
          <a class="btn btn-dark me-2" href="../auth/login.php">Acceder</a>
        </div>
      <?php endif; ?>
    </div>
  </nav>

  <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="notificationModalLabel">Detalles de la notificación</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <p id="notificationMessage"></p>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.getElementById("mark-all-as-read").addEventListener("click", function(event) {
      event.preventDefault();
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "../notification/mark_all_as_read.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
          var response = xhr.responseText;
          if (response === "success") {
            alert("Todas las notificaciones han sido marcadas como leídas.");
            window.location.reload();
          } else {
            alert("Hubo un error al marcar las notificaciones como leídas. Por favor, inténtalo de nuevo más tarde.");
          }
        }
      };
      xhr.send();
    });

    var deleteButtons = document.querySelectorAll(".delete-notification");
    deleteButtons.forEach(function(button) {
      button.addEventListener("click", function(event) {
        event.preventDefault();
        var notificationId = this.getAttribute("data-notification-id");
        var confirmDelete = confirm("¿Estás seguro de que deseas eliminar esta notificación?");
        if (confirmDelete) {
          var xhr = new XMLHttpRequest();
          xhr.open("POST", "../notification/notification_delete.php", true);
          xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
          xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
              var response = xhr.responseText;
              if (response === "success") {
                alert("La notificación ha sido eliminada correctamente.");
                window.location.reload();
              } else {
                alert("Hubo un error al eliminar la notificación. Por favor, inténtalo de nuevo más tarde.");
              }
            }
          };
          xhr.send("notification_id=" + encodeURIComponent(notificationId));
        }
      });
    });

    document.addEventListener('DOMContentLoaded', function() {
      var openedNotificationId;

      var notificationLinks = document.querySelectorAll('.notification-link');
      notificationLinks.forEach(function(link) {
        link.addEventListener('click', function(event) {
          event.preventDefault();
          openedNotificationId = this.getAttribute('data-notification-id');
          var modal = new bootstrap.Modal(document.getElementById('notificationModal'));
          modal.show();
          var xhr = new XMLHttpRequest();
          xhr.open("POST", "../notification/get_notification_message.php", true);
          xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
          xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
              var response = xhr.responseText;
              if (response) {
                document.getElementById('notificationMessage').textContent = response;
              } else {
                alert("Error al obtener el mensaje de la notificación.");
              }
            }
          };
          xhr.send("notification_id=" + encodeURIComponent(openedNotificationId));
        });
      });

      var notificationModal = document.getElementById('notificationModal');
      notificationModal.addEventListener('hidden.bs.modal', function() {
        document.getElementById('notificationMessage').textContent = "";
        document.body.classList.remove('modal-open');
        var backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
          backdrop.parentNode.removeChild(backdrop);
        }
        if (openedNotificationId) {
          var xhr = new XMLHttpRequest();
          xhr.open("POST", "../notification/mark_as_read.php", true);
          xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
          xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
              var response = xhr.responseText;
              if (response === "success") {
                var notificationElement = document.querySelector('.notification-link[data-notification-id="' + openedNotificationId + '"]');
                if (notificationElement) {
                  notificationElement.classList.remove('text-bold');
                }
              } else {
                alert("Error al marcar la notificación como leída.");
              }
            }
          };
          xhr.send("notification_id=" + encodeURIComponent(openedNotificationId));

          openedNotificationId = null;
        }
        window.location.reload();
      });
    });
  </script>