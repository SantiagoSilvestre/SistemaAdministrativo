<?php
if (!isset($seguranca)) {
    exit;
}
include_once 'app/sts/header.php';
?>
<body>
    <?php
    include_once 'app/sts/menu.php';
    $result_sobs_emps = "SELECT * FROM sts_sobs_emps WHERE sts_situacoe_id=1 ORDER BY ordem ASC";
    $resultado_sobs_emps = mysqli_query($conn, $result_sobs_emps);
    ?>
    <main role="main">
        <div class="jumbotron sobre-empresa" style="padding-bottom: 1rem; margin-bottom: 0px;">
            <div class="container">
                <h2 class="display-4 text-center">Sobre a Empresa</h2>
            </div>
        </div>
        <?php
        if (($resultado_sobs_emps) AND ( $resultado_sobs_emps->num_rows != 0)) {
            $cont_sob_emp = 1;
            while ($row_sob_emp = mysqli_fetch_assoc($resultado_sobs_emps)) {
                if ($cont_sob_emp == 1) {
                    ?>
                    <div class="jumbotron sobre-empresa">
                        <div class="container">
                            <div class="row featurette">
                                <div class="col-md-7 order-md-2 emp-text-mod-um">
                                    <h2 class="featurette-heading"><?php echo $row_sob_emp['titulo']; ?></h2>
                                    <p class="lead"><?php echo $row_sob_emp['descricao']; ?></p>
                                </div>
                                <div class="col-md-5 order-md-1 emp-img-mod-um">
                                    <img class="featurette-image img-fluid mx-auto" src="<?php echo pg . '/assets/imagens/sob_emp/' . $row_sob_emp['id'] . '/' . $row_sob_emp['imagem']; ?>" alt="<?php echo $row_sob_emp['titulo']; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $cont_sob_emp = 2;
                } else {
                    ?>
                    <div class="jumbotron sobre-empresa">
                        <div class="container">
                            <div class="row featurette">
                                <div class="col-md-7 emp-text-mod-dois">
                                    <h2 class="featurette-heading"><?php echo $row_sob_emp['titulo']; ?></h2>
                                    <p class="lead"><?php echo $row_sob_emp['descricao']; ?></p>
                                </div>
                                <div class="col-md-5 emp-img-mod-dois">
                                    <img class="featurette-image img-fluid mx-auto" src="<?php echo pg . '/assets/imagens/sob_emp/' . $row_sob_emp['id'] . '/' . $row_sob_emp['imagem']; ?>" alt="<?php echo $row_sob_emp['titulo']; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $cont_sob_emp = 1;
                }
            }
        }
        ?>

    </main>
    <?php
    include_once 'app/sts/rodape.php';
    include_once 'app/sts/rodape_lib.php';
    ?>
    <script>
        window.sr = ScrollReveal({reset: true});
        sr.reveal('.emp-text-mod-um', {
            duration: 1000,
            origin: 'rigth',
            distance: '20px'
        });
        sr.reveal('.emp-img-mod-um', {
            duration: 1000,
            origin: 'left',
            distance: '20px'
        });
        sr.reveal('.emp-text-mod-dois', {
            duration: 1000,
            origin: 'left',
            distance: '20px'
        });
        sr.reveal('.emp-img-mod-dois', {
            duration: 1000,
            origin: 'right',
            distance: '20px'
        });
    </script>
</body>

