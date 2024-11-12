<?php

   $op = new Operations();
   $estados = $op->select('*', 'estados');
?>


<div class="container mt-5">


    <?php
        require('views/components/client-form.php');
    ?>
</div>