<?php
$result_menu = "SELECT endereco, nome_pagina FROM sts_paginas WHERE lib_bloq=1 ORDER BY ordem ASC";
$resultado_menu = mysqli_query($conn, $result_menu);
?>
<header>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-primary">
        <div class="container">
            <a class="navbar-brand" href="<?php echo pg; ?>/home">Santiago</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="nav navbar-nav ml-auto">
                    <?php
                    while($row_menu = mysqli_fetch_assoc($resultado_menu)){
                        echo "<li class='nav-item menu'>";
                        echo "<a class='nav-link' href='".pg."/".$row_menu['endereco']."'>".$row_menu['nome_pagina']."</a> ";
                        echo "</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
</header>