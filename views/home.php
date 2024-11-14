<?php
    $current_page = isset($_GET['page']) ? $_GET['page'] : 'home';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel</title>
    <link rel="stylesheet" href="<?= ASSETS ?>/bootstrap.min.css">
    <link rel="stylesheet" href="<?= CSS ?>/css.css">
    <link rel="stylesheet" href="<?= CSS ?>/panel.css">
    <link rel="stylesheet" type="text/css" href="<?= ASSETS ?>/dataTables.min.css"">
    <script src=" https://cdn.jsdelivr.net/npm/clipboard@2.0.8/dist/clipboard.min.js">
    </script>
    <script src="<?= ASSETS ?>/jquery-3.6.0.min.js"></script>
    <script src="<?= ASSETS ?>/dataTables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/css/smart_wizard_all.min.css"
    rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/js/jquery.smartWizard.min.js"
    type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

</head>

<body class="d-flex">
    <?php require 'views/components/overlay.php'; ?>
    <button class="menu-toggle btn d-md-none" onclick="toggleSidebar()">☰ Menu</button>

    <?php require "views/components/lateral-bar.php"; ?>

    <div class="main-content mt-5">
        <main class="ms-sm-auto">
            <?php
                $filePath = "views/pages/{$current_page}.php";

                if (file_exists($filePath)) {
                    include $filePath;
                } else {
                    echo "<p>Página não encontrada!</p>";
                }
            ?>
        </main>
    </div>
    <script src="sweetalert2.all.min.js"></script>
    <script src="<?= ASSETS ?>/bootstrap.bundle.js"></script>
    <script src="<?= ASSETS ?>/jquery.mask.js"></script>
    <script src="<?= JS ?>/styles.js"></script>
    <script src="<?= JS ?>/components.js"></script>
    <script src="<?= JS ?>/clients.js"></script>
    <script src="<?= JS ?>/js.js"></script>
    <script src="<?= JS ?>/scripts.js"></script>
    <script src="<?= JS ?>/masks.js"></script>
    <script src="<?= JS ?>/index.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/js/all.min.js" integrity="sha512-6sSYJqDreZRZGkJ3b+YfdhB3MzmuP9R7X1QZ6g5aIXhRvR1Y/N/P47jmnkENm7YL3oqsmI6AK+V6AD99uWDnIw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


</body>

</html>