
<?php include_once __DIR__  . '/student-header-dashboard.php'; ?>

<div class="contenedor-sm">
    <?php include_once __DIR__ . '/../templates/alertas.php'; ?>
    <div id="item-container">
        <?php if(!empty($noticias)) {
            foreach ($noticias as $noti) { ?>
                <form class="form-noticia" action="/noticias-borrar" method="POST">
                    <h3><?php echo $noti->titulo; ?></h3>
                    <p><?php echo $noti->descripcion; ?></p>
                    <p style="font-size: 1.5rem;">Creado el: <?php echo $noti->fecha; ?></p>
                </form>
        <?php }
        } else {
            echo "<div style='width: 100%;text-align: center;'><p>No hay noticias</p></div>";

        }?>
    </div>
</div>
    
    <?php include_once __DIR__  . '/footer-dashboard.php'; ?>
    <script src="/build/js/sweetAlert.js"></script>
    <script type="text/javascript" src="/build/js/student.js"></script>