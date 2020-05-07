<?php
if (!isset($seguranca)) {
    exit;
}
include_once 'app/sts/header.php';
?>

<body>
    <?php
    include_once 'app/sts/menu.php';
    ?>
    <main role="main">
        <?php
        $result_carousels = "SELECT car.*,
                cor.cor
                FROM sts_carousels car
                INNER JOIN sts_cors cor ON cor.id=car.sts_cor_id
                WHERE car.sts_situacoe_id=1
                ORDER BY ordem ASC";
        $resultado_carousels = mysqli_query($conn, $result_carousels);
        if (($resultado_carousels) AND ( $resultado_carousels->num_rows != 0)) {
            ?>

            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <?php
                    $cont_marc = 0;
                    while ($row_marcador = mysqli_fetch_assoc($resultado_carousels)) {
                        echo "<li data-target='#myCarousel' data-slide-to='$cont_marc'></li>";
                        $cont_marc++;
                    }
                    ?>                    
                </ol>
                <div class="carousel-inner">
                    <?php
                    $cont_slide = 0;
                    $resultado_carousels = mysqli_query($conn, $result_carousels);
                    while ($row_slide = mysqli_fetch_assoc($resultado_carousels)) {
                        ?>
                        <div class="carousel-item <?php
                        if ($cont_slide == 0) {
                            echo 'active';
                        }
                        ?>">
                            <img class="second-slide img-fluid" src="<?php echo pg; ?>/assets/imagens/carousel/<?php echo $row_slide['id']; ?>/<?php echo $row_slide['imagem']; ?>" alt="<?php echo $row_slide['titulo']; ?>">
                            <div class="container">
                                <div class="carousel-caption <?php echo $row_slide['posicao_text']; ?>">
                                    <h1 class="d-none d-md-block"><?php echo $row_slide['titulo']; ?></h1>
                                    <p class="d-none d-md-block"><?php echo $row_slide['descricao']; ?></p>
                                    <p class="d-none d-md-block"><a class="btn btn-lg btn-<?php echo $row_slide['cor']; ?>" href="<?php echo $row_slide['link']; ?>" role="button"><?php echo $row_slide['titulo_botao']; ?></a></p>
                                </div>
                            </div>
                        </div>
                        <?php
                        $cont_slide++;
                    }
                    ?>
                </div>
                <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <?php
        }


        $result_servico = "SELECT * FROM sts_servicos LIMIT 1";
        $resultado_servico = mysqli_query($conn, $result_servico);
        $row_servico = mysqli_fetch_assoc($resultado_servico);
        ?>
        <div class="jumbotron servicos">
            <div class="container">
                <h2 class="display-4 text-center" style="margin-bottom: 40px;"><?php echo $row_servico['titulo']; ?></h2>
                <div class="card-deck card-servicos">
                    <div class="card text-center">
                        <div class="icon-row tamanh-icone">
                            <span class="step size-96 text-primary">
                                <i class="icon <?php echo $row_servico['icone_um']; ?>"></i>
                            </span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row_servico['nome_um']; ?></h5>
                            <p class="card-text lead"><?php echo $row_servico['descricao_um']; ?></p>      
                        </div>
                    </div>
                    <div class="card text-center">
                        <div class="icon-row tamanh-icone">
                            <span class="step size-96 text-primary">
                                <i class="icon <?php echo $row_servico['icone_dois']; ?>"></i>
                            </span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row_servico['nome_dois']; ?></h5>
                            <p class="card-text lead"><?php echo $row_servico['descricao_dois']; ?></p>
                        </div>
                    </div>
                    <div class="card text-center">
                        <div class="icon-row tamanh-icone ">
                            <span class="step size-96 text-primary">
                                <i class="icon <?php echo $row_servico['icone_tres']; ?>"></i>
                            </span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row_servico['nome_tres']; ?></h5>
                            <p class="card-text lead"><?php echo $row_servico['descricao_tres']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $result_video = "SELECT * FROM sts_videos LIMIT 1";
        $resultado_video = mysqli_query($conn, $result_video);
        $row_video = mysqli_fetch_assoc($resultado_video);
        ?>
        <div class="jumbotron depoimento">
            <div class="container">
                <h2 class="display-4 text-center" style="margin-bottom: 40px; color: #FFF;"><?php echo $row_video['titulo']; ?></h2>
                <p class="lead text-center" style="margin-bottom: 40px; color: #FFF;"><?php echo $row_video['descricao']; ?></p>
                <div class="card-deck">
                    <div class="card text-center dep-left">
                        <div class="embed-responsive embed-responsive-16by9">
<?php echo $row_video['video_um']; ?>
                        </div>
                    </div>
                    <div class="card text-center dep-center">
                        <div class="embed-responsive embed-responsive-16by9">
<?php echo $row_video['video_dois']; ?>
                        </div>							
                    </div>
                    <div class="card text-center dep-right">
                        <div class="embed-responsive embed-responsive-16by9">
<?php echo $row_video['video_tres']; ?>
                        </div>							
                    </div>
                </div>
            </div>
        </div>

        <?php
        $result_prod_home = "SELECT * FROM sts_prods_homes LIMIT 1";
        $resultado_prod_home = mysqli_query($conn, $result_prod_home);
        $row_prod_home = mysqli_fetch_assoc($resultado_prod_home);
        ?>
        <div class="jumbotron produto">
            <div class="container">
                <h2 class="display-4 text-center" style="margin-bottom: 40px;"><?php echo $row_prod_home['titulo']; ?></h2>
                <div class="row featurette">
                    <div class="col-md-7 prod-text">
                        <h2 class="featurette-heading"><?php echo $row_prod_home['subtitulo']; ?></h2>
                        <p class="lead"><?php echo $row_prod_home['descricao']; ?></p>
                    </div>
                    <div class="col-md-5 prod-img">
                        <img class="featurette-image img-fluid mx-auto" src="<?php echo pg . '/assets/imagens/prods_home/' . $row_prod_home['id'] . '/' . $row_prod_home['imagem']; ?>" alt="<?php echo $row_prod_home['subtitulo']; ?>">
                    </div>
                </div>
            </div>
        </div>	

        <?php
        $result_forms_emails = "SELECT * FROM sts_forms_emails LIMIT 1";
        $resultado_forms_emails = mysqli_query($conn, $result_forms_emails);
        $row_forms_emails = mysqli_fetch_assoc($resultado_forms_emails);
        ?>
        <div class="jumbotron cadastro-email paralaxe-email" style="background-image:url(<?php echo pg . "/assets/imagens/form_email/" . $row_forms_emails['id'] . "/" . $row_forms_emails['imagem']; ?>);">
            <div class="container">
                <div class="email-text">
                    <h2 class="display-4 text-center" style="margin-bottom: 40px"><?php echo $row_forms_emails['titulo']; ?></h2>
                    <p class="lead text-center" style="margin-bottom: 40px;"><?php echo $row_forms_emails['descricao']; ?></p>
                </div>
                <div class="email-form">
                    <form action="<?php echo pg; ?>/proc_cad_lead" method="POST">
                        <div class="form-row justify-content-center">
                            <div class="col-sm-3 my-1">
                                <label class="sr-only">E-mail</label>
                                <div class="input-group mb-2 mr-sm-2">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">@</div>
                                    </div>
                                    <input type="email" name="email" class="form-control" placeholder="Seu melhor e-mail">
                                </div>
                            </div>
                            <div class="col-auto my-1">
                                <input type="submit" class="btn btn-primary mb-2" value="<?php echo $row_forms_emails['titulo_botao']; ?>" name="SendCadLead">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>	


        <?php
        $result_perg_resp = "SELECT * FROM sts_pergs_resps WHERE sts_situacoe_id=1";
        $resultado_perg_resp = mysqli_query($conn, $result_perg_resp);
        ?>
        <div class="jumbotron perg-resp">
            <div class="container">
                <h2 class="display-4 text-center perg-resp-text" style="margin-bottom: 40px">Perguntas e Respostas</h2>
                <div class="perg-resp-cont">
                    <div id="accordion">
                        <?php
                        $cont_acord = 1;
                        while ($row_perg_resp = mysqli_fetch_assoc($resultado_perg_resp)) {
                            ?>
                            <div class="card">
                                <div class="card-header" id="heading<?php echo $row_perg_resp['id']; ?>">
                                    <h5 class="mb-0">
                                        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse<?php echo $row_perg_resp['id']; ?>" aria-expanded="false" aria-controls="collapse<?php echo $row_perg_resp['id']; ?>">
    <?php echo $row_perg_resp['pergunta']; ?>
                                        </button>
                                    </h5>
                                </div>
                                <div id="collapse<?php echo $row_perg_resp['id']; ?>" class="collapse <?php if ($cont_acord == 1) {
                                        echo "show";
                                    } ?>" aria-labelledby="heading<?php echo $row_perg_resp['id']; ?>" data-parent="#accordion">
                                    <div class="card-body">
                            <?php echo $row_perg_resp['resposta']; ?>
                                    </div>
                                </div>
                            </div>
    <?php
    //show
    $cont_acord++;
}
?>
                    </div>
                </div>
            </div>
        </div>	
    </main>
<?php
include_once 'app/sts/rodape.php';
include_once 'app/sts/rodape_lib.php';
?>

    <script>
        window.sr = ScrollReveal({reset: true});
        sr.reveal('.card-servicos', {
            duration: 1000,
            origin: 'bottom',
            distance: '20px'
        });
        sr.reveal('.dep-left', {
            duration: 1000,
            origin: 'left',
            distance: '20px'
        });
        sr.reveal('.dep-center', {
            duration: 1000,
            origin: 'bottom',
            distance: '20px'
        });
        sr.reveal('.dep-right', {
            duration: 1000,
            origin: 'right',
            distance: '20px'
        });
        sr.reveal('.prod-text', {
            duration: 1000,
            origin: 'left',
            distance: '20px'
        });
        sr.reveal('.prod-img', {
            duration: 1000,
            origin: 'right',
            distance: '20px'
        });
        sr.reveal('.email-text', {
            duration: 1000,
            origin: 'left',
            distance: '20px'
        });
        sr.reveal('.email-form', {
            duration: 1000,
            origin: 'right',
            distance: '20px'
        });
        sr.reveal('.perg-resp-text', {
            duration: 1000,
            origin: 'left',
            distance: '20px'
        });
        sr.reveal('.perg-resp-cont', {
            duration: 1000,
            origin: 'right',
            distance: '20px'
        });
    </script>
</body>

