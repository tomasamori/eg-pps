<?php session_start(); ?>
<?php include('../includes/header.php'); ?>

<style>

    body {
        background-color: #f3f5fc;
    }

    .tile {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 150px;
        border-radius: 8px;
        background: #f8f9fa;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        transition: background 0.3s, transform 0.3s;
        cursor: pointer;
        text-align: center;
        position: relative;
    }

    .tile:hover {
        background: #e9ecef;
        transform: scale(1.05);
    }

    .tile i {
        font-size: 2rem;
        margin-bottom: 10px;
    }

    .tile h5 {
        margin: 0;
        font-size: 1.2rem;
    }

    .tile p {
        font-size: 0.9rem;
        color: #6c757d;
    }

    .tile .badge {
        position: absolute;
        top: 10px;
        right: 10px;
        background: #007bff;
        color: #fff;
    }

</style>

<div class="container mt-5">
    <h1 class="text-center mb-5">Portal Administrativo</h1>
    <div class="row">

        <div class="col-md-3 mb-4">
            <div class="tile" onclick="location.href='../user/user.php';">
                <i class="fa-solid fa-users me-2"></i>
                <div>
                    <h5>Usuarios</h5>
                    <p></p>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="tile" onclick="location.href='../career/career.php';">
                <i class="fa-solid fa-graduation-cap me-2"></i>
                <div>
                    <h5>Carreras</h5>
                    <p></p>
                </div>
            </div>
        </div>

    </div>
</div>

<?php include('../includes/footer.php'); ?>