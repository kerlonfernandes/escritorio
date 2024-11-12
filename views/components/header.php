<?php

$userType = $_SESSION['type'];

$area = $userType == "Professor" ? "area-professor" : ($userType == 'Aluno' ? "area-aluno" : "");
$indicador = $userType == "Professor" ? "PROFESSOR" : ($userType == 'Aluno' ? "ALUNO" : "");
?>

<header>
    <div class="header-container">
        <a class="no-link" href="<?= SITE . "/" . $area ?>" style="margin-bottom: 6px; margin-left: -10px;">
            <span class="area-indicador"><i class="fa-solid fa-house" style="margin-bottom: 1px;">
                </i> ÁREA DO <?= $indicador ?></span></a>
        <span class="filter-icon"><i class="fa-solid fa-right-from-bracket"></i></span>
    </div>
</header>

<div class="area-indicativa">
    <img src="<?= SITE ?>/public/src/images/logo.webp" alt="">
</div>