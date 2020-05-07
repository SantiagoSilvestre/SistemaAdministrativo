<?php 
    if(!isset($seg)){
        exit;
    }
    include_once 'app/adms/include/head.php';
?>
<body>
    <?php
        include 'app/adms/include/header.php';
    ?>
    <div class="d-flex">
        <?php 
            include 'app/adms/include/menu.php'; 
            
            echo "Listar Páginas";
            echo "ID da página: ". $row_pg['id_pg'] ."<br>";
            include_once 'app/adms/include/rodape_lib.php'
        ?>
    </div>
</body>
