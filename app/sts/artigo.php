<?php
if (!isset($seguranca)) {
    exit;
}
$result_art = "SELECT art.*, 
            user.apelido,
            rob.tipo
            FROM sts_artigos art
            INNER JOIN adms_usuarios user ON user.id=art.adms_usuario_id
            INNER JOIN sts_robots rob ON rob.id=art.sts_robot_id
            WHERE slug='" . $endereco[1] . "' AND sts_situacoe_id=1 LIMIT 1";
$resultado_art = mysqli_query($conn, $result_art);
$row_art = mysqli_fetch_assoc($resultado_art);
$row_pagina['titulo'] = "Celke - ".$row_art['titulo'];
$row_pagina['robots'] = $row_art['tipo'];
$row_pagina['keywords'] = $row_art['keywords'];
$row_pagina['description'] = $row_art['description'];
$row_pagina['author'] = $row_art['author'];

include_once 'app/sts/header.php';
?>
<body>
    <?php
    include_once 'app/sts/menu.php';
    ?>
    <main role="main">
        <div class="jumbotron blog">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 blog-main">
                        <?php
                        if (($resultado_art) AND ( $resultado_art->num_rows != 0)) {
                            
                            ?>
                            <div class="blog-post">
                                <h2 class="blog-post-title"><?php echo $row_art['titulo']; ?></h2>                      
                                <?php
                                setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'portuguese');
                                date_default_timezone_set('America/Sao_Paulo');
                                ?>
                                <p class="blog-post-meta">
                                    <?php
                                    echo strftime('%d de %B de %Y', strtotime($row_art['created'])) . ", ";
                                    echo $row_art['apelido'];
                                    ?> 
                                </p>
                                <img src="<?php echo pg . '/assets/imagens/artigo/' . $row_art['id'] . '/' . $row_art['imagem']; ?>" class="img-fluid" alt="Responsive image" style="margin-bottom: 20px;">
                                <?php echo $row_art['conteudo']; ?>

                            </div><!-- /.blog-post -->
                            <nav class="blog-pagination">
                                <?php
                                $resul_art_ant = "SELECT slug FROM sts_artigos WHERE id < '" . $row_art['id'] . "' AND sts_situacoe_id=1 ORDER BY id DESC LIMIT 1";
                                $resultado_art_ant = mysqli_query($conn, $resul_art_ant);
                                if (($resultado_art_ant) AND ( $resultado_art_ant->num_rows != 0)) {
                                    $row_art_ant = mysqli_fetch_assoc($resultado_art_ant);
                                    echo "<a class='btn btn-outline-primary' href='" . pg . "/artigo/" . $row_art_ant['slug'] . "'>Anterior</a>";
                                }

                                //artigo proximo
                                $resul_art_pro = "SELECT slug FROM sts_artigos WHERE id > '" . $row_art['id'] . "' AND sts_situacoe_id=1 ORDER BY id ASC LIMIT 1";
                                $resultado_art_pro = mysqli_query($conn, $resul_art_pro);
                                if (($resultado_art_pro) AND ( $resultado_art_pro->num_rows != 0)) {
                                    $row_art_pro = mysqli_fetch_assoc($resultado_art_pro);
                                    echo "<a class='btn btn-outline-primary' href='" . pg . "/artigo/" . $row_art_pro['slug'] . "'>Proximo</a>";
                                }
                                ?>
                            </nav>

                            <?php
                            $result_qnt_ac = "UPDATE sts_artigos SET
                                qnt_acesso=qnt_acesso+1
                                WHERE id='".$row_art['id']."' ";
                            mysqli_query($conn, $result_qnt_ac);
                        } else {
                            $url_destino = pg . "/blog";
                            header("Location: $url_destino");
                            //echo "<div class='alert alert-danger' role='alert'>Artigo não encontrado!</div>";
                        }
                        ?>
                    </div>
                    <aside class="col-md-4 blog-sidebar">
                        <?php
                        $result_blog_sb = "SELECT * FROM sts_blogs_sobres WHERE sts_situacoe_id=1 LIMIT 1";
                        $resultado_blog_sb = mysqli_query($conn, $result_blog_sb);
                        if (($resultado_blog_sb) AND ( $resultado_blog_sb->num_rows != 0)) {
                            $row_blog_sb = mysqli_fetch_assoc($resultado_blog_sb);
                            ?>

                            <div class="p-3 mb-3 bg-light rounded">
                                <h4 class="font-italic"><?php echo $row_blog_sb['titulo']; ?></h4>
                                <p class="mb-0"><?php echo $row_blog_sb['descricao']; ?></p>
                            </div>
                            <?php
                        }

                        $result_art_rec = "SELECT titulo, slug FROM sts_artigos WHERE sts_situacoe_id=1 ORDER BY id DESC LIMIT 6";
                        $resultado_art_rec = mysqli_query($conn, $result_art_rec);
                        ?>
                        <div class="p-3">
                            <h4 class="font-italic">Recentes</h4>
                            <ol class="list-unstyled mb-0">
                                <?php
                                while ($row_art_rec = mysqli_fetch_assoc($resultado_art_rec)) {
                                    echo "<li><a href='" . pg . "/artigo/" . $row_art_rec['slug'] . "'>" . $row_art_rec['titulo'] . "</a></li>";
                                }
                                ?>
                            </ol>
                        </div>

                        <?php
                        $result_art_dest = "SELECT titulo, slug FROM sts_artigos WHERE sts_situacoe_id=1 ORDER BY qnt_acesso DESC LIMIT 6";
                        $resultado_art_dest = mysqli_query($conn, $result_art_dest);
                        ?>
                        <div class="p-3">
                            <h4 class="font-italic">Destaques</h4>
                            <ol class="list-unstyled">
                                <?php
                                while ($row_art_dest = mysqli_fetch_assoc($resultado_art_dest)) {
                                    echo "<li><a href='" . pg . "/artigo/" . $row_art_dest['slug'] . "'>" . $row_art_dest['titulo'] . "</a></li>";
                                }
                                ?>
                            </ol>
                        </div>
                    </aside><!-- /.blog-sidebar -->
                </div>
            </div>
        </div>
    </main>

    <?php
    include_once 'app/sts/rodape.php';
    include_once 'app/sts/rodape_lib.php';
    ?>
</body>